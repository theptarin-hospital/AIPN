<?php

namespace App\Libraries\Aipn;

use Exception;
use ZipArchive;
//use App\Models\AipnModel;
use App\Libraries\Aipn\AipnImport;
use App\Libraries\Aipn\AipnXml;

/**
 * All In-patient Claim Data File Specification : AIPN
 * @author suchart bunhachirat <suchartbu@gmail.com>
 * @link https://drive.google.com/file/d/1RL-iuL4bNWE8wzkCB_EcR6yf18EmGWlr/view?usp=share_link
 */
class AipnZip extends AipnXml {

    const ZIP_PATH = 'ZIPFiles/';

    protected $zip_name = null;
    private $zip_path = null;

    public function __construct(int $an, int $id) {
        try {
            parent::__construct($an);
            $this->setHeader();
            $files = new AipnImport();
            $ipadt_row_ = $files->facthIpadt($an);
            if (is_null($ipadt_row_)) {
                throw new Exception('AN ไม่มี');
            }
//            $this->setClaimAuth($ipadt_row_);
//            $this->setIPDx($model->facthIpdx($this->an));
//            $this->setIPOp($model->facthIpop($this->an));
//            $this->setInvoices($model->facthBillitems($this->an));
            $this->zip_path = $this->setZip($id);
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
    public function setZip(int $id) {
        parent::save();
        $zip = new ZipArchive();
        $this->zip_name = $this->hcare_id . $this->doc_type . $id;
        $zip_path = self::ZIP_PATH . $this->zip_name . '.zip';
        $zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile('XMLFiles/' . $this->file_name . '.xml', $this->file_name . '.xml');
        $zip->close();
        return $zip_path;
    }

    public function getZipPath() {
        return $this->zip_path;
    }

    public function getZipUrl() {
        return 'http://localhost/AIPN/public/' . $this->getZipPath();
    }
}
