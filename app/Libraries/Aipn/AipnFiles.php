<?php

namespace App\Libraries\Aipn;

use League\Csv\Reader;

/**
 * การใช้ไฟล์ CSV เพื่อใช้สร้าง XmlDocument AIPN
 * @author suchart bunhachirat <suchartbu@gmail.com>
 * @link https://drive.google.com/file/d/1RL-iuL4bNWE8wzkCB_EcR6yf18EmGWlr/view?usp=share_link
 */
class AipnFiles {

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
     * @return array getRowArray()
     */
    public function facthIpadt(string $an = '0') {
        $rows = $this->facthCSV('ipadt.csv');
        foreach ($rows as $row) {
            echo $row['AN'];
            print_r($row);
//            var_dump($row);
        }
//        $sql = "SELECT concat(`AN`,'|',`HN`,'|',`IDTYPE`,'|',`PIDPAT`,'|',`TITLE`,'|',`NAMEPAT`,'|',`DOB`,'|',`SEX`,'|',`MARRIAGE`,'|',`CHANGWAT`,'|',`AMPHUR`,'|',`NATION`,'|',`AdmType`,'|',`AdmSource`,'|',`DTAdm`,'|',`DTDisch`,'|',`LeaveDay`,'|',`DischStat`,'|',`DischType`,'|',`AdmWt`,'|',`DischWard`,'|',`Dept`) AS `ipadt`,`AN`, `Invoice`, `RECEIPT_DATE`, `ServiceType`, `CareAs` FROM `aipn_ipadt` WHERE `AN` = :an:";
//        $db = Database::connect();
//        return $db->query($sql, [
//                    'an' => $an,
//                ])->getRowArray();
    }
}
