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
            $as_['ipadt'] = $this->setIpadt($row);
            return array_merge($as_, $row);
//            print_r($row);
        }
//        $sql = "SELECT concat(`AN`,'|',`HN`,'|',`IDTYPE`,'|',`PIDPAT`,'|',`TITLE`,'|',`NAMEPAT`,'|',`DOB`,'|',`SEX`,'|',`MARRIAGE`,'|',`CHANGWAT`,'|',`AMPHUR`,'|',`NATION`,'|',`AdmType`,'|',`AdmSource`,'|',`DTAdm`,'|',`DTDisch`,'|',`LeaveDay`,'|',`DischStat`,'|',`DischType`,'|',`AdmWt`,'|',`DischWard`,'|',`Dept`) AS `ipadt`,`AN`, `Invoice`, `RECEIPT_DATE`, `ServiceType`, `CareAs` FROM `aipn_ipadt` WHERE `AN` = :an:";
//        $db = Database::connect();
//        return $db->query($sql, [
//                    'an' => $an,
//                ])->getRowArray();
    }

    public function setIpadt(array $r) {
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
     * @return array getResultArray()
     */
    public function facthIpdx(string $an) {
        $result_ = [];
        $rows = $this->facthCSV('ipdx.csv');
        foreach ($rows as $r) {
//            $ipdx_as = [
//                $r['DxType'], $r['CodeSys'], $r['Code'], $r['DiagTerm'], $r['DR'], $r['DateDiag'],
//            ];
            $as_['ipdx'] = [
                $r['DxType'], $r['CodeSys'], $r['Code'], $r['DiagTerm'], $r['DR'], $r['DateDiag'],
            ];
            $result_[] = array_merge($as_, $r);
//            print_r($row);
        }
//        print_r($result_);
//        die('facthIpdx');
//        $sql = "SELECT concat(`DxType`,'|',`CodeSys`,'|',`Code`,'|',`DiagTerm`,'|',`DR`,'|',`DateDiag`) AS `ipdx`,`AN` FROM `aipn_ipdx` WHERE `AN` = :an: order by DxType";
//        $db = Database::connect();
//        return $db->query($sql, [
//                    'an' => $an,
//                ])->getResultArray();
    }
}
