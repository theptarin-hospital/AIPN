<?php

namespace App\Controllers;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        print_r($model->facthExample());
        echo 'testing index';
        return view('welcome_message');
    }
}
