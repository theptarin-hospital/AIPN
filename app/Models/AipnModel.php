<?php

namespace App\Models;

use \Config\Database;
use CodeIgniter\Model;

/**
 * @author suchart bunhachirat <suchartbu@gmail.com>
 */
class AipnModel extends Model {

    public function facthIpadt(string $an) {
        $sql = "SELECT concat(`AN`,'|',`HN`,'|',`IDTYPE`,'|',`PIDPAT`,'|',`TITLE`,'|',`NAMEPAT`,'|',`DOB`,'|',`SEX`,'|',`MARRIAGE`,'|',`CHANGWAT`,'|',`AMPHUR`,'|',`NATION`,'|',`AdmType`,'|',`AdmSource`,'|',`DTAdm`,'|',`DTDisch`,'|',`LeaveDay`,'|',`DischStat`,'|',`DischType`,'|',`AdmWt`,'|',`DischWard`,'|',`Dept`) AS `ipadt`,`AN`, `Invoice`, `RECEIPT_DATE`, `ServiceType` FROM `aipn_ipadt` WHERE `AN` = :an:";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getRowArray();
    }

    public function facthIpdx(string $an) {
        $sql = "SELECT concat(`DxType`,'|',`CodeSys`,'|',`Code`,'|',`DiagTerm`,'|',`DR`,'|',`DateDiag`) AS `ipdx`,`AN` FROM `aipn_ipdx` WHERE `AN` = :an: order by DxType";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getRowArray();
    }

    public function facthIpop(string $an) {
        $sql = "SELECT  concat(`CodeSys`,'|',`Code`,'|',`ProcTerm`,'|',`DR`,'|',`DateIn`,'|',`DateOut`,'|',`Location`) AS `ipop` ,`AN` FROM `aipn_ipop` WHERE `AN` = :an:";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getRowArray();
    }

    public function facthBillitems(string $an) {
        $sql = "SELECT CONCAT( `ServDate`, '|', `BillGr`, '|', `LCCode`, '|', `Descript`, '|', `QTY`, '|', `UnitPrice`, '|', `ChargeAmt`, '|', `Discount`, '|', `ProcedureSeq`, '|', `DiagnosisSeq`, '|', `ClaimSys`, '|', `BillGrCS`, '|', `CSCode`, '|', `CodeSys`, '|', `STDCode`, '|', `ClaimCat`, '|', `DateRev`, '|', `ClaimUP`, '|', `ClaimAmt` ) AS `invoices`, `QTY` * `UnitPrice` AS `amount`, `AN`, `ClaimCat` FROM `aipn_billitems` WHERE `AN` = :an:";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getRowArray();
    }

}
