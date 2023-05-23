<?php

namespace App\Libraries\Aipn;

use DOMDocument;
use DateTime;

/**
 * 1. สร้าง XML ด้วย DomDocument('1.0', 'utf-8')
 * 2. สร้างแต่ละส่วนของ xml
 * 3. แปลงไฟล์ utf-8 เป็น windows-874
 * @author suchart bunhachirat <suchartbu@gmail.com>
 * @link https://drive.google.com/file/d/1RL-iuL4bNWE8wzkCB_EcR6yf18EmGWlr/view?usp=share_link
 */
class XmlDocument {

    protected $document = null;
    protected $hcare_id = '11720';
    protected $hmain_id = '11800';
    protected $hcare_name = 'รพ.เทพธารินทร์';
    protected $doc_type = 'AIPN';

    /**
     * DOMDocument Object
     * @var DOMDocument
     */
    protected $an = null;

    /**
     * IPADT 
     * @var array
     */
    private $ipadt_ = null;

    /**
     * @var DateTime
     */
    private $effective_time = null;
    protected $file_name = null;

    public function __construct($an) {
        $this->an = $an;
        $this->setDocument('1.0', 'utf-8');
    }

    public function setDocument($version, $encoding) {
        $this->document = new DOMDocument($version, $encoding);
        $this->document->preserveWhiteSpace = false;
        $this->document->formatOutput = true;
        $this->document->load($this->doc_type . '_utf8.xml'); //->publc/
    }

    /**
     * เนื้อหาส่วน:header
     * ข้อมูลเกี่ยวข้องกับประเภทเอกสาร และผู้จัดทำเอกสาร เป็นส่วนให้ข้อมูลหน่วยงาน เวลา และประเภท
     */
    public function setHeader() {
        $this->effective_time = new DateTime();
        $this->document->getElementsByTagName('DocClass')->item(0)->nodeValue = 'IPClaim';
        $this->document->getElementsByTagName('DocSysID')->item(0)->nodeValue = $this->doc_type;
        $this->document->getElementsByTagName('serviceEvent')->item(0)->nodeValue = 'ADT';
        $this->document->getElementsByTagName('authorID')->item(0)->nodeValue = $this->hcare_id;
        $this->document->getElementsByTagName('authorName')->item(0)->nodeValue = $this->hcare_name;
        $this->document->getElementsByTagName('effectiveTime')->item(0)->nodeValue = $this->effective_time->format('Y-m-d\TH:i:s');
    }

    /**
     * เนื้อหาส่วน:ClaimAuth
     * เป็นส่วนให้ข้อมูลการอนุมัติ บัญชีการเบิกจ่าย สถานพยาบาล และประเภทสถานพยาบาลที่รักษา
     * @param array $row_ ipadt data
     */
    public function setClaimAuth(array $row_) {
        $this->ipadt_ = $row_;
        $this->document->getElementsByTagName('UPayPlan')->item(0)->nodeValue = '80';
        $this->document->getElementsByTagName('ServiceType')->item(0)->nodeValue = $this->ipadt_['ServiceType'];
        $this->document->getElementsByTagName('Hmain')->item(0)->nodeValue = $this->hmain_id;
        $this->document->getElementsByTagName('Hcare')->item(0)->nodeValue = $this->hcare_id;
        $this->document->getElementsByTagName('CareAs')->item(0)->nodeValue = $this->ipadt_['CareAs'];
        $this->setIPADT();
    }

    /**
     * ข้อมูลผู้ป่วย และ ID ต่างๆ วันรับ/จำหน่าย และที่เกี่ยวกันการรับเป็นผู้ป่วยใน
     */
    private function setIPADT() {
        $this->document->getElementsByTagName('IPADT')->item(0)->nodeValue = $this->ipadt_['ipadt'];
    }

    /**
     * ข้อมูลการวินิจฉัย รหัสโรค ICD10
     * @param array $results_
     */
    public function setIPDx(array $results_) {
        $seq_id = 0;
        $node_value = PHP_EOL;
        foreach ($results_ as $row_) {
            $seq_id++;
            $node_value .= $seq_id . '|' . $row_['ipdx'] . PHP_EOL;
        }
        $this->document->getElementsByTagName('IPDx')->item(0)->setAttribute('Reccount', $seq_id);
        $this->document->getElementsByTagName('IPDx')->item(0)->nodeValue = $node_value;
    }

    /**
     * ข้อมูลการทำหัตถการและการผ่าตัด ICD9
     * @param array $results_
     */
    public function setIPOp(array $results_) {
        $seq_id = 0;
        $node_value = PHP_EOL;
        foreach ($results_ as $row_) {
            $seq_id++;
            $node_value .= $seq_id . '|' . $row_['ipop'] . PHP_EOL;
        }
        $this->document->getElementsByTagName('IPOp')->item(0)->setAttribute('Reccount', $seq_id);
        $this->document->getElementsByTagName('IPOp')->item(0)->nodeValue = $node_value;
    }

    /**
     * ข้อมูลค่ารักษาทุกรายการ
     * @param array $results_
     */
    protected function setInvoices(array $results_) {
        $node_value = PHP_EOL;
        $inv_ = ['total' => 0, 'total_d' => 0, 'total_x' => 0, 'discount' => 0];
        $seq_id = 0;
        foreach ($results_ as $row_) {
            $seq_id++;
            $node_value .= $seq_id . '|' . $row_['invoices'] . PHP_EOL;
            $inv_['total'] += $row_['amount'];
            $inv_['discount'] += $row_['discount'];
            if ($row_['ClaimCat'] == 'D') {
                $inv_['total_d'] += $row_['amount'];
            } else {
                $inv_['total_x'] += $row_['amount_x'];
            }
        }
        $this->document->getElementsByTagName('InvNumber')->item(0)->nodeValue = $this->ipadt_['Invoice']; //เลข Invoice ขนาดไม่เกิน 9 ตัวอักษร
        $this->document->getElementsByTagName('InvDT')->item(0)->nodeValue = $this->ipadt_['RECEIPT_DATE']; //วันเวลาที่ออก Invoice รูปแบบ YYYYMMDD
        $this->document->getElementsByTagName('BillItems')->item(0)->setAttribute('Reccount', $seq_id);
        $this->document->getElementsByTagName('BillItems')->item(0)->nodeValue = $node_value;
        $this->document->getElementsByTagName('InvAddDiscount')->item(0)->nodeValue = number_format($inv_['discount'], 2, '.', '');
        $this->document->getElementsByTagName('DRGCharge')->item(0)->nodeValue = number_format($inv_['total_d'], 4, '.', ''); // รูปแบบ 0000.0000
        $this->document->getElementsByTagName('XDRGClaim')->item(0)->nodeValue = number_format($inv_['total_x'], 4, '.', ''); // รูปแบบ 0000.0000
    }

    /**
     * บันทึกไฟล์ข้อมูลเปิก
     */
    public function save() {
        $this->file_name = $this->hcare_id . '-' . $this->doc_type . '-' . $this->an . '-' . $this->effective_time->format('YmdHis');
        $this->document->save('XMLFiles/' . $this->file_name . '-utf8.xml');
        $this->create_xml($this->convert_xml());
    }

    /**
     * MD5Hash
     * @return string EndNote HMAC
     */
    private function convert_xml() {
        $file_read = fopen('XMLFiles/' . $this->file_name . '-utf8.xml', "r") or die("Unable to open file!");
        $file_write = fopen('TXTFiles/' . $this->file_name . '.txt', "w") or die("Unable to open file!");
        fgets($file_read); //อ่านบรรทัดแรกก่อน
        while (!feof($file_read)) {
            $str_line = trim(fgets($file_read), "\n");
            if ($str_line != "") {
//                echo($str_line);
                fwrite($file_write, iconv("UTF-8", "tis-620", $str_line . "\r\n"));
            }
        }
        fclose($file_read);
        fclose($file_write);
        return hash_file("md5", 'TXTFiles/' . $this->file_name . ".txt");
    }

    /**
     * XML windows-874
     * @param type $str_hash
     */
    private function create_xml(string $str_hash) {
        $file_read = fopen('TXTFiles/' . $this->file_name . '.txt', "r") or die("Unable to open file!");
        $file_write = fopen('XMLFiles/' . $this->file_name . '.xml', "w") or die("Unable to open file!");
        fwrite($file_write, '<?xml version="1.0" encoding="windows-874"?>');
        while (!feof($file_read)) {
            fwrite($file_write, fgets($file_read));
        }
        fwrite($file_write, '<?EndNote HMAC = "' . $str_hash . '" ?>');
    }

}
