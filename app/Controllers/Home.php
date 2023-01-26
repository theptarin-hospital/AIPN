<?php

namespace App\Controllers;

use App\Libraries\Aipn\Aipn;

class Home extends BaseController {

    public function index() {
        $an = '660062001';
        $aipn = new Aipn($an);
        $aipn->save_zip();
        echo 'date_default_timezone_get()|' . date_default_timezone_get() . PHP_EOL;
        echo 'dapp_timezone()|' . app_timezone() . PHP_EOL;
        return view('welcome_message');
    }

}
