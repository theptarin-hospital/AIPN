<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line

/**
 * @author suchart bunhachirat
 */
class Pages extends BaseController {

    public function index() {
        return view('welcome_message');
    }

    public function view($page = 'home') {
        if (!is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter
        return view('pages/' . $page);

//        return view('templates/header', $data)
//                . view('pages/' . $page)
//                . view('templates/footer');
    }
}
