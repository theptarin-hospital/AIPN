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
     * แฟ้มข้อมูลเบิกผู้ป่วยใน AIPN
     * - ใส่เลขไฟล์ที่ต้องการสร้าง
     * - อัพโหลดไฟล์ IPADT
     * - อัพโหลดไฟล์ IPDx
     * - อัพโหลดไฟล์ IPOp
     * - อัพโหลดไฟล์ Invoices
     * - สร้างไฟล์ AIPN Claim XML
     * - สร้างไฟล์ Claim ZIP ส่งสกส.
     */
    public function index() {
        return view(self::PAGES_FOLDER . 'aipn-index');
    }

    /**
     * การอัพโหลดไฟล์ AIPN Claim CSV 4 ไฟล์
     * - อัพโหลดไฟล์ IPADT
     * - อัพโหลดไฟล์ IPDx
     * - อัพโหลดไฟล์ IPOp
     * - อัพโหลดไฟล์ Invoices
     */
    public function upload() {
        if (!$this->request->is('post')) {
            return redirect()->route('aipn');
//            return view('signup');
        }

        /**
         * AN. 9หลัก เป็นตัวเลข
         */
        $rules = ['an' => 'exact_length[9]|is_natural',];

        if (!$this->validate($rules)) {
            return redirect()->route('aipn');
//            return view('signup');
        }

//        return view('success');
        return view(self::PAGES_FOLDER . 'aipn-upload', $this->request->getPost(['an',]));
    }

    /**
     * นำเข้าไฟล์
     * - ip
     * @return type
     */
    public function create() {
        return $this->ipadt_upload();
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
        $input = false;
//        $input = $this->validate([
//            'an' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
//        ]);
        if (!$input) {
            return view(self::PAGES_FOLDER . 'aipn-ipadt', $this->request->getPost(['an',]));
        }
        return redirect()->route('aipn');
    }

    public function ipadt_upload() {
        $input = $this->validate([
            'ipadt_file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
        ]);
        if (!$input) {
            $data['validation'] = $this->validator;
            return view(self::PAGES_FOLDER . 'aipn-index', $data);
        }
        $ipadt_file = $this->request->getFile('file');
        if (!$ipadt_file->hasMoved()) {
            $ipadt_file->move( WRITEPATH .'uploads/aipn','123456789_ipadt.csv');
            $filepath = WRITEPATH .'aipn/ipadt.csv';

            $data = ['uploaded_fileinfo' => new File($filepath)];

            return view('upload_success', $data);
        }

        $data = ['errors' => 'The file has already been moved.'];
        print_r($data);

        return view('upload_form', $data);
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
