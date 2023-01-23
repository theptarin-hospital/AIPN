<?php

namespace App\Libraries\Aipn;

use DOMDocument;
use DateTime;

/**
 * 1. สร้าง AIPN XML ด้วย DomDocument('1.0', 'utf-8')
 * 2. สร้างแต่ละส่วนของ xml
 * 3. แปลงไฟล์ utf-8 เป็น windows-874
 * @author suchart bunhachirat <suchartbu@gmail.com>
 * @link https://drive.google.com/file/d/1RL-iuL4bNWE8wzkCB_EcR6yf18EmGWlr/view?usp=share_link
 */
class XmlDocument {

    /**
     * DOMDocument Object
     * @var DOMDocument
     */
    public $document = null;
    public $an = null;

    /**
     * @var DateTime
     */
    private $CreateDateTime = null;

    public function __construct($an) {
        $this->an = $an;
        $this->setDocument('1.0', 'utf-8');
    }

    public function setDocument($version, $encoding) {
        $this->document = new DOMDocument($version, $encoding);
        $this->document->preserveWhiteSpace = false;
        $this->document->formatOutput = true;
        $this->document->load('aipn_utf8.xml');
    }

    /**
     * เนื้อหาส่วน:header
     * ข้อมูลเกี่ยวข้องกับประเภทเอกสาร และผู้จัดทำเอกสาร เป็นส่วนให้ข้อมูลหน่วยงาน เวลา และประเภท
     */
    public function setHeader() {
        $this->CreateDateTime = new DateTime();
        $this->document->getElementsByTagName('DocClass')->item(0)->nodeValue = 'IPClaim';
        $this->document->getElementsByTagName('DocSysID')->item(0)->nodeValue = 'AIPN';
        $this->document->getElementsByTagName('serviceEvent')->item(0)->nodeValue = 'ADT';
        $this->document->getElementsByTagName('authorID')->item(0)->nodeValue = '11720';
        $this->document->getElementsByTagName('authorName')->item(0)->nodeValue = 'รพ.เทพธารินทร์';
        $this->document->getElementsByTagName('effectiveTime')->item(0)->nodeValue = $this->CreateDateTime->format('Y-m-d\TH:i:s');
    }

    /**
     * เนื้อหาส่วน:ClaimAuth
     * เป็นส่วนให้ข้อมูลการอนุมัติ บัญชีการเบิกจ่าย สถานพยาบาล และประเภทสถานพยาบาลที่รักษา
     */
    public function setClaimAuth() {
        $this->document->getElementsByTagName('UPayPlan')->item(0)->nodeValue = '80';
        $this->document->getElementsByTagName('Hmain')->item(0)->nodeValue = '11720';
        $this->document->getElementsByTagName('Hcare')->item(0)->nodeValue = '11720';
        $this->document->getElementsByTagName('CareAs')->item(0)->nodeValue = 'M';
    }

    /**
     * ข้อมูลผู้ป่วย และ ID ต่างๆ วันรับ/จำหน่าย และที่เกี่ยวกันการรับเป็นผู้ป่วยใน
     * @param string $node_value
     */
    public function setIPADT(string $node_value) {
        $this->dom->getElementsByTagName('IPADT')->item(0)->nodeValue = $node_value;
    }

    /**
     * ข้อมูลการวินิจฉัย รหัสโรค ICD10
     * @param array $row_
     */
    public function setIPDx(array $row_) {
//        $rec_count = $this->get_aipn_ipdx();
        $seq_id = 0;
        $node_value = "\n";
        foreach ($row_ as $value) {
            $seq_id++;
            $node_value .= $seq_id . '|' . $value['ipdx'] . "\n";
        }
        $this->dom->getElementsByTagName('IPDx')->item(0)->setAttribute('Reccount', $rec_count);
        $this->dom->getElementsByTagName('IPDx')->item(0)->nodeValue = $node_value;
    }

    public function save() {
        $this->file_name = '14354-AIPN-' . $this->an . '-' . $this->CreateDateTime->format('YmdHis');
        //$this->zip_name = '14354AIPN';
        $this->document->save('XMLFiles/' . $this->file_name . '-utf8.xml');
        $this->create_xml($this->convert_xml());
    }

    private function convert_xml() {
        $file_read = fopen('XMLFiles/' . $this->file_name . '-utf8.xml', "r") or die("Unable to open file!");
        $file_write = fopen('TXTFiles/' . $this->file_name . '.txt', "w") or die("Unable to open file!");
        fgets($file_read); //อ่านบรรทัดแรกก่อน
        while (!feof($file_read)) {
            $str_line = trim(fgets($file_read), "\n");
            if ($str_line != "") {
                fwrite($file_write, iconv("UTF-8", "tis-620", $str_line . "\r\n"));
            }
        }
        fclose($file_read);
        fclose($file_write);
        return hash_file("md5", 'TXTFiles/' . $this->file_name . ".txt");
    }

    private function create_xml($str_hash) {
        $file_read = fopen('TXTFiles/' . $this->file_name . '.txt', "r") or die("Unable to open file!");
        $file_write = fopen('XMLFiles/' . $this->file_name . '.xml', "w") or die("Unable to open file!");
        fwrite($file_write, '<?xml version="1.0" encoding="windows-874"?>');
        while (!feof($file_read)) {
            fwrite($file_write, fgets($file_read));
        }
        fwrite($file_write, '<?EndNote HMAC = "' . $str_hash . '" ?>');
    }

    public function sayHi() {
        return "AIPN Hello World!";
    }

}
