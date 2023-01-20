<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries\Aipn;

use DOMDocument;
use DateTime;

/**
 * Description of AIPNDocument
 *
 * @author it
 */
class XmlDocument {

    public $Document;
    public $an = 123456;
    private $DateTime;

    public function __construct($version = '1.0', $encoding = 'utf-8') {
        $this->setDocument($version, $encoding);
    }

    public function setDocument($version, $encoding) {
        $this->Document = new DOMDocument($version, $encoding);
        $this->Document->preserveWhiteSpace = false;
        $this->Document->formatOutput = true;
        $this->Document->load('aipn_utf8.xml');
    }

    public function setHeader() {
        $this->Document->getElementsByTagName('DocClass')->item(0)->nodeValue = 'IPClaim';
        $this->Document->getElementsByTagName('DocSysID')->item(0)->nodeValue = 'AIPN';
        $this->Document->getElementsByTagName('serviceEvent')->item(0)->nodeValue = 'ADT';
        $this->Document->getElementsByTagName('authorID')->item(0)->nodeValue = '14354';
        $this->Document->getElementsByTagName('authorName')->item(0)->nodeValue = 'รพ.ภัทร-ธนบุรี';
        /* prantip    $this->dom->getElementsByTagName('DocumentRef')->item(0)->nodeValue = $this->an; */
        $this->DateTime = new DateTime();
        $this->Document->getElementsByTagName('effectiveTime')->item(0)->nodeValue = $this->DateTime->format('Y-m-d\TH:i:s');
    }

    public function setClaimAuth() {
        $this->Document->getElementsByTagName('UPayPlan')->item(0)->nodeValue = '80';
        //$this->Document->getElementsByTagName('ServiceType')->item(0)->nodeValue = $this->service_type;
        $this->Document->getElementsByTagName('Hmain')->item(0)->nodeValue = '14354';
        $this->Document->getElementsByTagName('Hcare')->item(0)->nodeValue = '14354';
        $this->Document->getElementsByTagName('CareAs')->item(0)->nodeValue = 'M';
    }

    public function save() {
        $this->file_name = '14354-AIPN-' . $this->an . '-' . $this->DateTime->format('YmdHis');
        //$this->zip_name = '14354AIPN';
        $this->Document->save('XMLFiles/' . $this->file_name . '-utf8.xml');
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
