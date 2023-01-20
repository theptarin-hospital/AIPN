<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\AIPNDocument;

class Home extends BaseController {

    public function index() {
        $AIPN = new AIPNDocument();
        echo 'TEST--->' . $AIPN->sayHi();
        $model = new UserModel();
        print_r($model->facthExample());
        echo 'testing index';
        return view('welcome_message');
    }

}
