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
            return array_merge([
                'ipadt' => $this->setIpadt($row),
                'Invoice' => $row['BillNo'],
                'RECEIPT_DATE' => $row['BillDate'],
                'ins_type_code' => $row['InsTypeCode'],
                'ins_total' => $row['InsTotal'],
                'ins_room_board' => $row['InsRoomBoard'],
                'ins_prof_fee' => $row['InsProfFee'],
                'ins_other' => $row['InsOther']
                    ], $row);
        }
    }

    /**
     * กำหนด IPADT สำหรับใช้ใน XML  
     * @param array $r
     * @return string
     */
    private function setIpadt(array $r) {
//        $sql = "SELECT concat(`AN`,'|',`HN`,'|',`IDTYPE`,'|',`PIDPAT`,'|',`TITLE`,'|',`NAMEPAT`,'|',`DOB`,'|',`SEX`,'|',`MARRIAGE`,'|',`CHANGWAT`,'|',`AMPHUR`,'|',`NATION`,'|',`AdmType`,'|',`AdmSource`,'|',`DTAdm`,'|',`DTDisch`,'|',`LeaveDay`,'|',`DischStat`,'|',`DischType`,'|',`AdmWt`,'|',`DischWard`,'|',`Dept`) AS `ipadt`,`AN`, `Invoice`, `RECEIPT_DATE`, `ServiceType`, `CareAs` FROM `aipn_ipadt` WHERE `AN` = :an:";
        $fields_ = [
            $r['AN'], $r['HN'], $r['IDTYPE'], $r['PIDPAT'], $r['TITLE'], $r['NAMEPAT'], $r['DOB'], $r['SEX'],
            $r['MARRIAGE'], $r['CHANGWAT'], $r['AMPHUR'], $r['NATION'], $r['AdmType'], $r['AdmSource'],
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
            $results_[] = array_merge([
                'invoices' => $this->setInvoice($row),
                'amount' => $row['QTY'] * $row['UnitPrice'],
                'amount_x' => $row['XDRG'],
                'discount' => $row['Discount'],
                    ], $row);
        }
        return $results_;
    }

    /*
     * กำหนด Invoices สำหรับใช้ใน XML  
     * @param array $r Row record
     * @return string
     */

    private function setInvoice(array $r) {
//         $sql = "SELECT CONCAT( `ServDate`, '|', `BillGr`, '|', `LCCode`, '|', `Descript`, '|', `QTY`, '|', `UnitPrice`, '|', `ChargeAmt`, '|', `Discount`, '|', `ProcedureSeq`, '|', `DiagnosisSeq`, '|', `ClaimSys`, '|', `BillGrCS`, '|', `CSCode`, '|', `CodeSys`, '|', `STDCode`, '|', `ClaimCat`, '|', `DateRev`, '|', `ClaimUP`, '|', `ClaimAmt` ) AS `invoices`, `QTY` * `UnitPrice` AS `amount`, `XDRG` AS `amount_x`,`Discount` AS `discount`, `AN`, `ClaimCat` FROM `aipn_billitems` WHERE `AN` = :an:";
//         , '|', `ClaimCat`, '|', `DateRev`, '|', `ClaimUP`, '|', `ClaimAmt` ) AS `invoices`, `QTY` * `UnitPrice` AS `amount`, `XDRG` AS `amount_x`,`Discount` AS `discount`, `AN`, `ClaimCat` FROM `aipn_billitems` WHERE `AN` = :an:";
        $fields_ = [
            $r['ServDate'], $r['BillGr'], $r['LCCode'], $r['Descript'],
            number_format($r['QTY'], 2, '.', ''), number_format($r['UnitPrice'], 4, '.', ''),
            number_format($r['ChargeAmt'], 4, '.', ''), number_format($r['Discount'], 4, '.', ''),
            $r['ProcedureSeq'], $r['DiagnosisSeq'], $r['ClaimSys'], $r['BillGrCS'], $r['CSCode'], $r['CodeSys'],
            $r['STDCode'], $r['ClaimCat'], $r['DateRev'], number_format($r['ClaimUP'], 2, '.', ''),
            number_format($r['ClaimAmt'], 4, '.', ''),
        ];
        return implode('|', $fields_);
    }
}
