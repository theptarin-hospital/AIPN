<?php

namespace App\Controllers;

use App\Models\AipnModel;
use App\Libraries\Aipn\Aipn;

class Home extends BaseController {

    public function index() {
        $an = '652225702';
        $aipn = new Aipn($an);
        return view('welcome_message');
    }
    
    public function index_() {
        $an = '652225702';
        $model = new AipnModel();
        $row_ = $model->facthIpadt($an);
        $aipn = new XmlDocument($an);
        $aipn->setHeader();
        $aipn->setClaimAuth();
        $aipn->setIPADT($row_['ipadt']);
        $aipn->save();
        print_r($aipn->document);
        echo 'TEST--->' . $aipn->sayHi();
//        $model = new AipnModel();
//        print_r($model->facthIpadt($an));
        return view('welcome_message');
    }

}
