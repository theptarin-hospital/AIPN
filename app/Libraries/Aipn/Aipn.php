<?php

namespace App\Libraries\Aipn;

use Exception;
use App\Models\AipnModel;
use App\Libraries\Aipn\XmlDocument;

/**
 * All In-patient Claim Data File Specification : AIPN
 * @author suchart bunhachirat <suchartbu@gmail.com>
 * @link https://drive.google.com/file/d/1RL-iuL4bNWE8wzkCB_EcR6yf18EmGWlr/view?usp=share_link
 */
class Aipn extends XmlDocument {

    public function __construct($an) {
        try {
            parent::__construct($an);
            $this->setHeader();
            $model = new AipnModel();
            $ipadt_row_ = $model->facthIpadt($an);
            if (is_null($ipadt_row_)) {
                throw new Exception('AN ไม่มี');
            }
            $this->setClaimAuth($ipadt_row_);
            $this->setIPDx($model->facthIpdx($this->an));
            $this->setIPOp($model->facthIpop($this->an));
            $this->setInvoices($model->facthBillitems($this->an));
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            
        }
    }

    public function save() {
        parent::save();
    }

}
