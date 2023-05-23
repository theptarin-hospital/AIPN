<?php

namespace App\Controllers;

use App\Libraries\Aipn\Aipn;

class Home extends BaseController {

    public function index() {
        $an = '660062001';
        $id = 10043;
//        $data_ = ['an' => $an, $id => 'id'];
        $aipn = new Aipn($an, $id);
//        echo 'GEN : ' . $an . ' Download -> ' . $aipn->getZipUrl();
//        echo base_url($aipn->save_zip($id));
//        echo $aipn->save_zip($id);
//        echo 'date_default_timezone_get()|' . date_default_timezone_get() . PHP_EOL;
//        echo 'dapp_timezone()|' . app_timezone() . PHP_EOL;
        return view('welcome_message', ['an' => $an, $id => 'id', 'url' => $aipn->getZipUrl()]);
    }

}
