<?php

namespace App\Libraries\Aipn;

use Exception;
use ZipArchive;
use App\Libraries\Aipn\AipnImport;
use App\Libraries\Aipn\AipnXml;

/**
 * All In-patient Claim Data File Specification : AIPN
 *  สร้างไฟล์ XML และ ZIP สำหรับดาวน์โหลดใช้งาน
 * @author suchart bunhachirat <suchartbu@gmail.com>
 * @link https://drive.google.com/file/d/1RL-iuL4bNWE8wzkCB_EcR6yf18EmGWlr/view?usp=share_link
 */
class AipnZip extends AipnXml {

    const ZIP_PATH = 'ZIPFiles/';
    const XML_PATH = 'XMLFiles/';

    protected $zip_name = null;

//    private $zip_path = null;

    public function __construct(int $an) {
        try {
            parent::__construct($an);
            $this->setHeader();
            $files = new AipnImport();
            /**
             * @todo ตรวจสอบ AN ก่อนสร้างไฟล์
             */
            $ipadt_row_ = $files->facthIpadt($an);
            if (is_null($ipadt_row_)) {
                throw new Exception('AN ไม่มี');
            }
            $this->setClaimAuth($ipadt_row_);
            $this->setIPDx($files->facthIpdx($this->an));
            $this->setIPOp($files->facthIpop($this->an));
            $this->setInvoices($files->facthBillitems($this->an));
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            
        }
    }

    /**
     * สร้าง ZIP สำหรับส่งอีเมล์
     * - กำหนดชื่อไฟล์ HcodeDocTypeSessionNo.Zip
     * @param type $id
     * @return string
     */
    private function setZip(int $id) {
        parent::save();
        $zip = new ZipArchive();
        $this->zip_name = $this->hcare_id . $this->doc_type . $id;
        $zip_path = self::ZIP_PATH . $this->zip_name . '.zip';
        $zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile(self::XML_PATH . $this->file_name . '.xml', $this->file_name . '.xml');
        $zip->close();
        return $zip_path;
    }

    /**
     * XML ZIP File Download URL
     * @return string URL base_url/zip path/file name.
     */
    public function getZip(int $id) {
        return base_url($this->setZip($id));
    }

//    public function getZipPath() {
//        return $this->zip_path;
//    }
//    /**
//     * XML ZIP File Download URL
//     * @return string URL base_url/zip path/file name.
//     */
//    public function getZipUrl() {
//        return base_url($this->getZipPath());
//    }
}
