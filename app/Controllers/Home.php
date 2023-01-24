<?php

namespace App\Controllers;

use App\Libraries\Aipn\Aipn;

class Home extends BaseController {

    public function index() {
        $an = '652225702';
        $aipn = new Aipn($an);
        $aipn->save();
        return view('welcome_message');
    }

}
