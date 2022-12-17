<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class my_exception extends Exception {
    
}

/**
 * โปรแกรมสร้างไฟล์ AIPN ตัวอย่างข้อมูลจากไฟล์ 14354-AIPN-5800001-20150517213147.xml
 * 1. สร้าง xlm ไฟล์เริ่มต้นด้วย DomDocument('1.0', 'utf-8')
 * 2. สร้างแต่ละส่วนของ xml ทั้งหมด
 * 3. แปลงไฟล์ utf-8 เป็น windows-874
 * @author orr Modify by prantip
 * @link  ข้อกำหนดไฟล์ AIPN https://drive.google.com/file/d/0B-ZGLhvwK9V7YUttVk4zV2FOVjg/view?usp=sharing
 */
class cipn_xlm {

    /**
     * XML Object ของ DomDocument 
     */
    private $dom = null;
    /*
	private $create_datetime = null;
    private $filename = "";
    private $pathname = "";
	*/

    /**
     * AN. รหัสผู้ป่วยใน
     */
    private $AN = 0; 

	private $invoice_no = "";

	private $receipt_date = "";

	private $service_type = "";
    /**
     * ค่าตัวเลขวันที่เวลาที่ของไฟล์ รูปแบบ YYYYMMDDHHMMSS
     */
    private $file_datetime = null;
    
    /**
     * ชื่อไฟล์ CIPN 
     */
    private $file_name = "";

	private $zip_name = "";

    /**
     * ข้อมูลเกี่ยวกับผู้ป่วยที่เบิกค่ารักษา จากตาราง aipn_ipadt
     * 1. IPADT ค่าตามที่กำหนดใน XML
     * 2. auth_code รหัสอ้างอิงจากระบบ PAA
     * 3. auth_dt วันทีเวลาในเอกสารตอบกลับ PAA
     */
    private $aipn_ipadt = null;

    /**
     * ข้อมูลวินิจฉัยและหัตถการ จากตาราง aipn_ipdx
     * 1. auth_code รหัสอ้างอิงจากระบบ PAA
     * 2. ipdxop ค่าตามที่กำหนดใน XML ส่วนแรก
     * 3. datein วันเวลาที่เริ่ม
     * 4. dateout วันเวลาที่สิ้นสุด
     */
    private $aipn_ipdx = null;

    /**
     * ข้อมูลวินิจฉัยและหัตถการ จากตาราง aipn_ipop
     * 1. auth_code รหัสอ้างอิงจากระบบ PAA
     * 2. ipdxop ค่าตามที่กำหนดใน XML ส่วนแรก
     * 3. datein วันเวลาที่เริ่ม
     * 4. dateout วันเวลาที่สิ้นสุด
     */
    private $aipn_ipop = null;

    /**
     * ข้อมูลค่ารักษา จากตาราง drgs_invoices
     * 1. invoices ค่าตามที่กำหนดใน XML
     * 2. amount ยอดรวมแต่ละรายการที่หักส่วนลดแล้ว
     */
    private $drgs_invoices = null;

    /**
     * ข้อมูลค่ารักษา จากตาราง drgs_cipn_claim
     * 
     */
    private $drgs_cipn_claim = null;

    public function __construct($an) {
        if ($an == 0) {
            throw new Exception('AN. มีค่าเป็นศูนย์');
        }
        $this->an = $an; //เพิ่มส่วนตรวจสอบ AN.
        $this->get_aipn_ipadt();
        $this->dom = new DomDocument('1.0', 'utf-8');
        $this->dom->preserveWhiteSpace = FALSE;
        $this->dom->formatOutput = TRUE;
        $this->dom->load('utf8.xml');
        $this->file_datetime = new DateTime(); 
        $this->Header();
        $this->ClaimAuth();
        $this->IPADT();
        $this->IPDx();
        $this->IPOp();
        $this->Invoices();

/* แสดงผลบน จอภาพ */
        echo $this->dom->saveXML();
    }

    /**
     * ตรวจสอบข้อมูลจาก AN. เพื่อจัดทำไฟล์ AIPN 
     * ถ้าถูกต้องจะได้ค่าเพื่อใช้กับ ClaimAuth และ IPADT
     * @access private
     */
    private function get_aipn_ipadt() {
        $dsn = 'mysql:host=localhost;dbname=aipn';
        $username = 'root';
        $password = 'phatara';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT concat(`AN`,'|',`HN`,'|',`IDTYPE`,'|',`PIDPAT`,'|',`TITLE`,'|',`NAMEPAT`,'|',`DOB`,'|',`SEX`,'|',`MARRIAGE`,'|',`CHANGWAT`,'|',`AMPHUR`,'|',`NATION`,'|',`AdmType`,'|',`AdmSource`,'|',`DTAdm`,'|',`DTDisch`,'|',`LeaveDay`,'|',`DischStat`,'|',`DischType`,'|',`AdmWt`,'|',`DischWard`,'|',`Dept`) AS `ipadt`,`AN`, `Invoice`, `RECEIPT_DATE`, `ServiceType` FROM `aipn_ipadt`";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute();
        $this->aipn_ipadt = $stmt->fetch();
		$this->AN = $this->aipn_ipadt['AN'];
		$this->invoice_no = $this->aipn_ipadt['Invoice'];
		$this->receipt_date = $this->aipn_ipadt['RECEIPT_DATE'];
		$this->service_type = $this->aipn_ipadt['ServiceType'];
    }

    /**
     * ข้อมูลจากที่เบิกค่ารักษา เพื่อใช้ในส่วน IPDx
     * @access private
     */
    private function get_aipn_ipdx() {
        $dsn = 'mysql:host=localhost;dbname=aipn';
        $username = 'root';
        $password = 'phatara';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT concat(`sequence`,'|',`DxType`,'|',`CodeSys`,'|',`Code`,'|',`DiagTerm`,'|',`DR`,'|',`DateDiag`) AS `ipdx` FROM `aipn_ipdx`";
        $stmt = $db_conn->prepare($sql);
		$stmt->execute();
        $rec_count = $stmt->rowCount();
        $this->aipn_ipdx = $stmt->fetchAll();
        return $rec_count;
    }

    /**
     * ข้อมูลจากที่เบิกค่ารักษา เพื่อใช้ในส่วน IPOp
     * @access private
     */
    private function get_aipn_ipop() {
        $dsn = 'mysql:host=localhost;dbname=aipn';
        $username = 'root';
        $password = 'phatara';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT  concat(`sequence`,'|',`CodeSys`,'|',`Code`,'|',`ProcTerm`,'|',`DR`,'|',`DateIn`,'|',`DateOut`,'|',`Location`) AS `ipop` FROM `aipn_ipop` ";
        $stmt = $db_conn->prepare($sql);
		$stmt->execute();
        $rec_count = $stmt->rowCount();
        $this->aipn_ipop = $stmt->fetchAll();
        return $rec_count;
    }

    /**
     * ค้นหาข้อมูลจาก AN. ของ PAA ที่เบิกค่ารักษา เพื่อใช้ในส่วน Invoices
     * @access private
     */
    private function get_aipn_billitems() {
        $dsn = 'mysql:host=localhost;dbname=aipn';
        $username = 'root';
        $password = 'phatara';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT CONCAT( `sequence`, '|', `ServDate`, '|', `BillGr`, '|', `LCCode`, '|', `Descript`, '|', `QTY`, '|', `UnitPrice`, '|', `ChargeAmt`, '|', `Discount`, '|', `ProcedureSeq`, '|', `DiagnosisSeq`, '|', `ClaimSys`, '|', `BillGrCS`, '|', `CSCode`, '|', `CodeSys`, '|', `STDCode`, '|', `ClaimCat`, '|', `DateRev`, '|', `ClaimUP`, '|', `ClaimAmt` ) AS `invoices`, `QTY` * `UnitPrice` AS `amount`, `AN` FROM `aipn_billitems` ";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute(); 
        $rec_count = $stmt->rowCount();
        $this->aipn_billitems = $stmt->fetchAll();
        return $rec_count;
    }

    /**
     * Header เป็นข้อมูลที่เกี่ยวข้องกับประเภทเอกสาร และผู้จัดทำเอกสาร ซึ่งรพ. จะใช้ AN. เป็นรหัสอ้างอิง
     * @access private
     */
    private function Header() {
        $this->dom->getElementsByTagName('DocClass')->item(0)->nodeValue = 'IPClaim';
        $this->dom->getElementsByTagName('DocSysID')->item(0)->nodeValue = 'AIPN';
        $this->dom->getElementsByTagName('serviceEvent')->item(0)->nodeValue = 'ADT';
        $this->dom->getElementsByTagName('authorID')->item(0)->nodeValue = '14354';
        $this->dom->getElementsByTagName('authorName')->item(0)->nodeValue = 'รพ.ภัทร-ธนบุรี';
    /* prantip    $this->dom->getElementsByTagName('DocumentRef')->item(0)->nodeValue = $this->an; */
		
        $this->dom->getElementsByTagName('effectiveTime')->item(0)->nodeValue = $this->file_datetime->format('Y-m-d\TH:i:s');

		/*
	    $this->dom->getElementsByTagName('effectiveTime')->item(0)->nodeValue = $this->create_datetime->format('Y-m-d\TH:i:s');
		*/
    }

    /**
     * ClaimAuth เป็นข้อมูลเอกสารการขอนุมัติ PAA จากโปรแกรม aipn_ipadt.php
     * @access private
     */
    private function ClaimAuth() {
		$this->dom->getElementsByTagName('UPayPlan')->item(0)->nodeValue = '80';
		$this->dom->getElementsByTagName('ServiceType')->item(0)->nodeValue = $this->service_type;
		$this->dom->getElementsByTagName('Hmain')->item(0)->nodeValue = '14354';
		$this->dom->getElementsByTagName('Hcare')->item(0)->nodeValue = '14354';
        $this->dom->getElementsByTagName('CareAs')->item(0)->nodeValue = 'M';
    }

    /**
     * IPADT เป็นข้อมูลเกี่ยวกับผู้ป่วย การรับ การจำหน่าย ฯลฯ โปรแกรม aipn_ipadt.php
     * @access private
     */
    private function IPADT() {
        $this->dom->getElementsByTagName('IPADT')->item(0)->nodeValue = $this->aipn_ipadt['ipadt'];
    }

    /**
     * ipdx ส่วน xml ข้อมูลวินิจฉัยและหัตถการ
     * @access private
     */
    private function IPDx() {
        $rec_count = $this->get_aipn_ipdx() ;
        $node_value = "\n";
        foreach ($this->aipn_ipdx as $value) {
            $node_value .= $value['ipdx'] . "\n";
        }
        $this->dom->getElementsByTagName('IPDx')->item(0)->setAttribute('Reccount', $rec_count);
        $this->dom->getElementsByTagName('IPDx')->item(0)->nodeValue = $node_value;

    }

    /**
     * ipop ส่วน xml ข้อมูลวินิจฉัยและหัตถการ
     * @access private
     */
    private function IPOp() {
        $rec_count = $this->get_aipn_ipop() ;
        $node_value = "\n";
        foreach ($this->aipn_ipop as $value) {
            $node_value .= $value['ipop'] . "\n";
        }

        $this->dom->getElementsByTagName('IPOp')->item(0)->setAttribute('Reccount', $rec_count);
        $this->dom->getElementsByTagName('IPOp')->item(0)->nodeValue = $node_value;
    }

    /**
     * Invoices ส่วน xml ค่ารักษาทุกรายการ
     * @access private
     */
    private function Invoices() {
        $rec_count = $this->get_aipn_billitems();
        $node_value = "\n";
        $inv_discount = 0;
		$inv_total = 0;
		$inv_totalx = 0;
        foreach ($this->aipn_billitems as $value) {
            $node_value .= $value['invoices'] . "\n";
            $inv_total += $value['amount'];
        }
/**		echo('test271');
		print_r($node_value); */
        $this->dom->getElementsByTagName('InvNumber')->item(0)->nodeValue = $this->invoice_no; //เลข Invoice ขนาดไม่เกิน 9 ตัวอักษร
        $this->dom->getElementsByTagName('InvDT')->item(0)->nodeValue = $this->receipt_date; //วันเวลาที่ออก Invoice รูปแบบ YYYYMMDD
        $this->dom->getElementsByTagName('BillItems')->item(0)->setAttribute('Reccount', $rec_count);
        $this->dom->getElementsByTagName('BillItems')->item(0)->nodeValue = $node_value;
        $this->dom->getElementsByTagName('InvAddDiscount')->item(0)->nodeValue = number_format($inv_discount, 2, '.', '');
        $this->dom->getElementsByTagName('DRGCharge')->item(0)->nodeValue = number_format($inv_total, 4, '.', ''); // รูปแบบ 0000.0000
        $this->dom->getElementsByTagName('XDRGClaim')->item(0)->nodeValue = number_format($inv_totalx, 4, '.', ''); // รูปแบบ 0000.0000
    }


    /**
     * แปลงไฟล์ UTF8 เป็น TIS-620 ปรับรูปแบบไฟล์เพื่อให้ windows ใช้งานได้
     * @access private
     * @return string hash_value ของไฟล์
     */
    private function convert_xml() {
        $file_read = fopen($this->file_name . '-utf8.xml', "r") or die("Unable to open file!");
        $file_write = fopen($this->file_name . '.txt', "w") or die("Unable to open file!");
        fgets($file_read); //อ่านบรรทัดแรกก่อน
        while (!feof($file_read)) {
            $str_line = trim(fgets($file_read), "\n");
            if ($str_line != "") {
                fwrite($file_write, iconv("UTF-8", "tis-620", $str_line . "\r\n"));
            }
        }
        fclose($file_read);
        fclose($file_write);
        return hash_file("md5", $this->file_name . ".txt");
    }

    /**
     * สร้างไฟล์ XML CIPN 
     * @access private
     */
    private function create_xml($str_hash) {
        $file_read = fopen($this->file_name . '.txt', "r") or die("Unable to open file!");
        $file_write = fopen($this->file_name . '.xml', "w") or die("Unable to open file!");
        fwrite($file_write, '<?xml version="1.0" encoding="windows-874"?>');
        while (!feof($file_read)) {
            fwrite($file_write, fgets($file_read));
        }
        fwrite($file_write, '<?EndNote HMAC = "' . $str_hash . '" ?>');
    }

    /**
     * สร้างไฟล์ AIPN กำหนดชื่อไฟล์ตามรูป [รหัสรพ.]-AIPN-[AN.]-[$this->file_datetime].xml
     * @access private
     */
    public function save() {
        $this->file_name = '14354-AIPN-' . $this->AN . '-' . $this->file_datetime->format('YmdHis');
		$this->zip_name = '14354AIPN';
        $this->dom->save($this->file_name . '-utf8.xml');
        $this->create_xml($this->convert_xml());
    }

	 /**
     * สร้าง ZIP AIPN ตามข้อกำหนด
     */
    public function save_zip($id=10001) {
        $zip = new ZipArchive();
		//$file_name = '14354-AIPN-650827101-20221126165222.xml';
		$this->zip_name .= $id;
		//$this->zip_name = $this->zip_name.$id;
        $zip_path = 'download/'.$this->zip_name . '.zip';
        $zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		$zip->addFile($this->file_name.'.xml');
		$zip->close();
        return $zip_path;
    }

}

/* $my = new cipn_xlm('5800001');
$my->save();
$my->save_zip();*/
