<?php

namespace App\Controllers;

use App\Libraries\Aipn\Aipn;

class Home extends BaseController {

    public function index() {
        $an = '660062001';
        $aipn = new Aipn($an);
//        $aipn->save();
        $aipn->save_zip();
        return view('welcome_message');
    }

}
