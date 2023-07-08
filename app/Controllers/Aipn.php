<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

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
    /**
     * การนำไฟล์เข้า
     * - ต้องมี AN.
     * - เลือกไฟล์ CSV
     * - แสดงผมการนำเข้าไฟล์สำเร็จ
     * - เลือกส่งไฟล์ต่อไป
     * @return type
     */
    public function ipadt() {
        return view(self::PAGES_FOLDER . 'aipn-ipadt', $this->request->getPost(['an',]));
    }

    public function ipadt_upload() {
        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
        ]);
        if (!$input) {
            $data['validation'] = $this->validator;
            return view(self::PAGES_FOLDER . 'aipn-index', $data);
        }
        $ipadt_file = $this->request->getFile('file');
        if (!$ipadt_file->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $ipadt_file->store();

            $data = ['uploaded_fileinfo' => new File($filepath)];

            return view('upload_success', $data);
        }

        $data = ['errors' => 'The file has already been moved.'];
        print_r($data);

//        return view('upload_form', $data);
        return 'test';
    }

    public function ipdx() {
        return view('upload_success', $data);
//        if (!$this->request->is('post')) {
//            return view(self::PAGES_FOLDER . 'aipn-index');
//        }
//        return view(self::PAGES_FOLDER . 'aipn-ipadt', $this->request->getPost(['an',]));
    }

    public function about() {
        return view(self::PAGES_FOLDER . 'aipn-about');
    }

    public function contact() {
        return view(self::PAGES_FOLDER . 'aipn-contact');
    }
}
