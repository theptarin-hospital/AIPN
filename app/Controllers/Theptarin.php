<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Theptarin extends BaseController {

    private $data = ['page_title' => 'Theptarin Hospital', 'theme_path' => 'asset/theptarin/',];

    public function index() {
        return $this->view();
    }

    private function view($page = 'theptarin') {
        if (!is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }
        return view('templates/theptarin_header', $this->data)
                . view('pages/' . $page)
                . view('templates/theptarin_footer');
    }
}
