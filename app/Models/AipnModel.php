<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use \Config\Database;
use CodeIgniter\Model;

/**
 * Description of UserModel
 *
 * @author it
 */
class AipnModel extends Model {

    public function facthIpadt(string $an) {
        $sql = "SELECT concat(`AN`,'|',`HN`,'|',`IDTYPE`,'|',`PIDPAT`,'|',`TITLE`,'|',`NAMEPAT`,'|',`DOB`,'|',`SEX`,'|',`MARRIAGE`,'|',`CHANGWAT`,'|',`AMPHUR`,'|',`NATION`,'|',`AdmType`,'|',`AdmSource`,'|',`DTAdm`,'|',`DTDisch`,'|',`LeaveDay`,'|',`DischStat`,'|',`DischType`,'|',`AdmWt`,'|',`DischWard`,'|',`Dept`) AS `ipadt`,`AN`, `Invoice`, `RECEIPT_DATE`, `ServiceType` FROM `aipn_ipadt` WHERE `AN` = :an:";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getRowArray();
    }

}
