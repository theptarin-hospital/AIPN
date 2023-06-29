<?php
namespace App\Controllers;
/**
 * AIPN STEP
 * - AN. INPUT FORM.
 * - UPLOAD FILES.
 * - TRANSFOR FILES TO XML.
 * - DOWLOAD ZIP
 */
class Bootstrap extends BaseController {
    public function index() {
        return view('bootstrap/cover/index');
    }
}
