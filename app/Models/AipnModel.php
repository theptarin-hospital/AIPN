<?php

namespace App\Models;

use \Config\Database;
use CodeIgniter\Model;

/**
 * @author suchart bunhachirat <suchartbu@gmail.com>
 */
class AipnModel extends Model {

    /**
     * ข้อมูลเกี่ยวกับผู้ป่วยใน
     * @param string $an AN.
     * @return array getRowArray()
     */
    public function facthIpadt(string $an) {
        $sql = "SELECT concat(`AN`,'|',`HN`,'|',`IDTYPE`,'|',`PIDPAT`,'|',`TITLE`,'|',`NAMEPAT`,'|',`DOB`,'|',`SEX`,'|',`MARRIAGE`,'|',`CHANGWAT`,'|',`AMPHUR`,'|',`NATION`,'|',`AdmType`,'|',`AdmSource`,'|',`DTAdm`,'|',`DTDisch`,'|',`LeaveDay`,'|',`DischStat`,'|',`DischType`,'|',`AdmWt`,'|',`DischWard`,'|',`Dept`) AS `ipadt`,`AN`, `Invoice`, `RECEIPT_DATE`, `ServiceType`, `CareAs` FROM `aipn_ipadt` WHERE `AN` = :an:";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getRowArray();
    }

    /**
     * ข้อมูลการวินิจฉัยโรค ICD10
     * @param string $an AN.
     * @return array getResultArray()
     */
    public function facthIpdx(string $an) {
        $sql = "SELECT concat(`DxType`,'|',`CodeSys`,'|',`Code`,'|',`DiagTerm`,'|',`DR`,'|',`DateDiag`) AS `ipdx`,`AN` FROM `aipn_ipdx` WHERE `AN` = :an: order by DxType";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getResultArray();
    }

    /**
     * ข้อมูลการทำหัตถการและการผ่าตัด ICD9
     * @param string $an AN.
     * @return array getResultArray()
     */
    public function facthIpop(string $an) {
        $sql = "SELECT  concat(`CodeSys`,'|',`Code`,'|',`ProcTerm`,'|',`DR`,'|',`DateIn`,'|',`DateOut`,'|',`Location`) AS `ipop` ,`AN` FROM `aipn_ipop` WHERE `AN` = :an:";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getResultArray();
    }

    /**
     * ข้อมูลค่ารักษาทุกรายการ
     * @param string $an AN.
     * @return array getResultArray()
     */
    public function facthBillitems(string $an) {
        $sql = "SELECT CONCAT( `ServDate`, '|', `BillGr`, '|', `LCCode`, '|', `Descript`, '|', `QTY`, '|', `UnitPrice`, '|', `ChargeAmt`, '|', `Discount`, '|', `ProcedureSeq`, '|', `DiagnosisSeq`, '|', `ClaimSys`, '|', `BillGrCS`, '|', `CSCode`, '|', `CodeSys`, '|', `STDCode`, '|', `ClaimCat`, '|', `DateRev`, '|', `ClaimUP`, '|', `ClaimAmt` ) AS `invoices`, `QTY` * `UnitPrice` AS `amount`, `XDRG` AS `amount_x`,`Discount` AS `discount`, `AN`, `ClaimCat` FROM `aipn_billitems` WHERE `AN` = :an:";
        $db = Database::connect();
        return $db->query($sql, [
                    'an' => $an,
                ])->getResultArray();
    }

}
