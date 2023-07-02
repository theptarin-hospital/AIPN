<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Theptarin extends BaseController {

    public function index() {
        return view('pages/theptarin', $this->data());
    }

    private function data() {
        return['page_title' => 'Theptarin Hospital', 'theme_path' => 'asset/theptarin/'];
    }
}
