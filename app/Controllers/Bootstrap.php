<?php

namespace App\Controllers;

/**
 * @link http://localhost:8080/bs5-examples Testing Pages
 * @link https://www.shekztech.com/how-to-add-css-and-js-files-in-codeigniter-4/ How to add CSS and JS files in codeigniter 4
 */
class Bootstrap extends BaseController {

    public function index() {
        return view('bootstrap');
    }

    public function view($page = 'home') {
        if (!is_file(APPPATH . 'Views/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
                . view( $page)
                . view('templates/footer');
    }
}
