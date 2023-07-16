<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use CodeIgniter\Files\FileCollection;

/**
 * AIPN STEP
 * - AN. INPUT FORM.
 * - UPLOAD FILES.
 * - TRANSFOR FILES TO XML.
 * - DOWNLOAD ZIP
 */
class Aipn extends BaseController {

    const PAGES_FOLDER = 'pages/';
    const RULES = [
        'num' => 'required',
        'ipadt' => 'uploaded[ipadt]|max_size[ipadt,2048]|ext_in[ipadt,csv]',
    ];

    /**
     * แฟ้มข้อมูลเบิกผู้ป่วยใน AIPN
     * - period เลขงวดการส่ง เริ่มต้น 1 - 9999
     * - อัพโหลดไฟล์ IPADT
     * - อัพโหลดไฟล์ IPDx
     * - อัพโหลดไฟล์ IPOp
     * - อัพโหลดไฟล์ Invoices
     */
    public function index() {
        return view(self::PAGES_FOLDER . 'aipn-index');
    }

    /**
     * การตรวจสอบประมวลผลไฟล์ AIPN Claim จาก CSV ไฟล์
     * - สร้างไฟล์ AIPN Claim XML
     * - สร้างไฟล์ Claim ZIP เพื่อให้ดาวน์โหลด ใช้ส่งสกส.
     */
    public function upload() {
        $validation = \Config\Services::validation();
        if (!$this->request->is('post')) {
            return redirect()->route('aipn');
        }
        if (!$this->validate(self::RULES)) {
            print_r($validation->getErrors());
            die('Missing Rules');
            return redirect()->route('aipn');
        }
        $info_ = $this->setUploadFiles();
        $data_ = ['uploaded_fileinfo' => $info_['ipadt']];
        return view(self::PAGES_FOLDER . 'aipn-success', $data_);
    }

    /**
     * จัดการเตรียมไฟล์อัพโหลด
     * - กำหนดโฟลเดอร์เพื่อนำเข้าไฟล์
     */
    private function setUploadFiles() {
        $aipnFiles = new FileCollection([FCPATH . 'index.php', ROOTPATH . 'spark',]);
        print_r($aipnFiles->get());
        die('aipnFiles');
//        $aipnFiles->addDirectory(WRITEPATH . 'TEST');
        $files_['ipadt'] = $this->request->getFile('ipadt');
        $filepath = WRITEPATH . 'uploads/aipn/';
        $fileinfo_ = [];
        foreach ($files_ as $id => $val) {
            if (!$val->hasMoved()) {
                $val->move($filepath, $id . '.csv');
                $fileinfo_[$id] = new File($filepath . $id . '.csv');
            }
        }
        return $fileinfo_;
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
            $ipadt_file->move(WRITEPATH . 'uploads/aipn', '123456789_ipadt.csv');
            $filepath = WRITEPATH . 'aipn/ipadt.csv';

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
