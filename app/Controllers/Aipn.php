<?php

namespace App\Controllers;

/**
 * AIPN STEP
 * - AN. INPUT FORM.
 * - UPLOAD FILES.
 * - TRANSFOR FILES TO XML.
 * - DOWNLOAD ZIP
 */
class Aipn extends BaseController {

    const PAGES_FOLDER = 'pages/';

    /**
     * AN. AIPN
     * @return
     */
    public function index() {
        return view(self::PAGES_FOLDER . 'aipn-index');
    }

    public function ipadt() {
        return view(self::PAGES_FOLDER . 'aipn-ipadt');
    }

    public function about() {
        return view(self::PAGES_FOLDER . 'aipn-about');
    }

    public function contact() {
        return view(self::PAGES_FOLDER . 'aipn-contact');
    }
}
