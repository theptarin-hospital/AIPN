<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\Aipn\XmlDocument;

class Home extends BaseController {

    public function index() {
        $aipn = new XmlDocument('987654321');
        $aipn->setHeader();
        $aipn->setClaimAuth();
        $aipn->save();
        print_r($aipn->document);
        echo 'TEST--->' . $aipn->sayHi();
        //$model = new UserModel();
        //print_r($model->facthExample());
        //echo 'testing index';
        return view('welcome_message');
    }

}
