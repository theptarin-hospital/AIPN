<?php

namespace App\Libraries\Aipn;

use Exception;
use App\Models\AipnModel;
use App\Libraries\Aipn\XmlDocument;

/**
 * All In-patient Claim Data File Specification : AIPN
 * @author suchart bunhachirat <suchartbu@gmail.com>
 */
class Aipn extends XmlDocument {

    public function __construct($an) {
        try {
            $model = new AipnModel();
            $row_ = $model->facthIpadt($an);
            if (is_null($row_)) {
                throw new Exception('AN ไม่มี');
            }
            print_r($row_);
            parent::__construct($an);
            $this->setHeader();
            $this->setClaimAuth();
            $this->setIPADT($row_['ipadt']);
//            $this->setIPDx($row_);
//            $this->setIPOp($row_);
//            $this->setInvoices($row_);
            $this->save();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            
        }
    }

}
