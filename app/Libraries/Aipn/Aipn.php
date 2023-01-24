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
            $model = new AipnModel();
            $ipadt_row_ = $model->facthIpadt($an);
            if (is_null($ipadt_row_)) {
                throw new Exception('AN ไม่มี');
            }
            parent::__construct($an);
            $this->setHeader();
            $this->setClaimAuth();
            $this->setIPADT($ipadt_row_['ipadt']);
            $this->setIPDx($model->facthIpdx($an));
//            $this->setIPOp($row_);
//            $this->setInvoices($row_);
            $this->save();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            
        }
    }

}
