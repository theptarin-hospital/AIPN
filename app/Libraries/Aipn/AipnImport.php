<?php

namespace App\Libraries\Aipn;

use League\Csv\Reader;

/**
 * การใช้ไฟล์ CSV เพื่อใช้สร้าง XmlDocument AIPN
 * @author suchart bunhachirat <suchartbu@gmail.com>
 * @link https://drive.google.com/file/d/1RL-iuL4bNWE8wzkCB_EcR6yf18EmGWlr/view?usp=share_link
 */
class AipnImport {

    const IMPORT_FOLDER = WRITEPATH . 'aipn/imports/';

    public function __construct() {
        
    }

    public function facthCSV(string $file_name) {
        $path = self::IMPORT_FOLDER . $file_name;
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // use the first line as headers for rows
        return $csv->getRecords();
    }

    /**
     * ข้อมูลเกี่ยวกับผู้ป่วยใน
     * @param string $an AN.
     * @return array One Record
     */
    public function facthIpadt(string $an = '0') {
        $rows = $this->facthCSV('ipadt.csv');
        foreach ($rows as $row) {
            return array_merge(['ipadt' => $this->setIpadt($row)], $row);
        }
    }

    /**
     * กำหนด IPADT สำหรับใช้ใน XML  
     * @param array $r
     * @return string
     */
    private function setIpadt(array $r) {
        $fields_ = [
            $r['AN'], $r['HN'], $r['IDTYPE'], $r['PIDPAT'], $r['TITLE'], $r['NAMEPAT'], $r['DOB'], $r['SEX'],
            $r['MARRIAGE'], $r['CHANGWAT'], $r['AUMPHUR'], $r['NATION'], $r['AdmType'], $r['AdmSource'],
            $r['DTAdm'], $r['DTDisch'], $r['LeaveDay'], $r['DischStat'], $r['DischType'], $r['AdmWt'], $r['DischWard'],
            $r['Dept'],
        ];
        return implode('|', $fields_);
    }

    /**
     * ข้อมูลการวินิจฉัยโรค ICD10
     * @param string $an AN.
     * @return array ResultArray
     */
    public function facthIpdx(string $an) {
        $results_ = [];
        $rows = $this->facthCSV('ipdx.csv');
        foreach ($rows as $row) {
            $results_[] = array_merge(['ipdx' => $this->setIpdx($row)], $row);
        }
        return $results_;
    }

    /**
     * กำหนด IPDx สำหรับใช้ใน XML  
     * @param array $r
     * @return string
     */
    private function setIpdx(array $r) {
        $fields_ = [
            $r['DxType'], $r['CodeSys'], $r['Code'], $r['DiagTerm'], $r['DR'], $r['DateDiag'],
        ];
        return implode('|', $fields_);
    }

    /**
     * ข้อมูลการทำหัตถการและการผ่าตัด ICD9
     * @param string $an
     * @return array Results
     */
    public function facthIpop(string $an) {
        $results_ = [];
        $rows = $this->facthCSV('ipop.csv');
        foreach ($rows as $row) {
            $results_[] = array_merge(['ipop' => $this->setIpop($row)], $row);
        }
        return $results_;
    }

    /**
     * กำหนด IPOp สำหรับใช้ใน XML  
     * @param array $r Row record
     * @return string
     */
    private function setIpop(array $r) {
        $fields_ = [
            $r['CodeSys'], $r['Code'], $r['ProcTerm'], $r['DR'], $r['DateTimeIn'], $r['DateTimeOut'], $r['Location'],
        ];
        return implode('|', $fields_);
    }

    /**
     * ข้อมูลค่ารักษาทุกรายการ
     * @param string $an
     * @return array Results
     */
    public function facthBillitems(string $an) {
        $results_ = [];
        $rows = $this->facthCSV('billitems.csv');
        foreach ($rows as $row) {
            $results_[] = array_merge(['invoices' => $this->setInvoice($row)], $row);
        }
        return $results_;
    }
    /*
     * กำหนด Invoices สำหรับใช้ใน XML  
     * @param array $r Row record
     * @return string
     */
    private function setInvoice(array $r) {
        $fields_ = [
            $r['CodeSys'], $r['Code'], $r['ProcTerm'], $r['DR'], $r['DateTimeIn'], $r['DateTimeOut'], $r['Location'],
        ];
        return implode('|', $fields_);
    }
}
