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
    const UPLOAD_FOLDER = WRITEPATH . 'aipn/uploads/';
    const IMPORT_FOLDER = WRITEPATH . 'aipn/imports/';
    const RULES = [
        'num' => 'required',
        'ipadt' => 'uploaded[ipadt]|max_size[ipadt,2048]|ext_in[ipadt,csv]',
        'ipdx' => 'uploaded[ipdx]|max_size[ipdx,2048]|ext_in[ipdx,csv]',
        'ipop' => 'uploaded[ipop]|max_size[ipop,2048]|ext_in[ipop,csv]',
        'billitems' => 'uploaded[billitems]|max_size[billitems,2048]|ext_in[billitems,csv]',
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
        $info_ = $this->setFiles();
        $data_ = ['uploaded_fileinfo' => $info_['ipadt']];
        return view(self::PAGES_FOLDER . 'aipn-success', $data_);
    }

    /**
     * จัดการเตรียมไฟล์อัพโหลด
     * - ลบไฟล์โฟลเดอร์อัพโหลดเดิมทั้งหมด
     * - คัดลอกสร้างไฟล์โฟลเดอร์สำหรับนำเข้าไฟล์
     */
    private function setFiles() {
        helper('filesystem');
        delete_files(self::IMPORT_FOLDER);
        delete_files(self::UPLOAD_FOLDER);
        $files_['ipadt'] = $this->request->getFile('ipadt');
        $files_['ipdx'] = $this->request->getFile('ipdx');
        $files_['ipop'] = $this->request->getFile('ipop');
        $files_['billitems'] = $this->request->getFile('billitems');
        $filepath = self::UPLOAD_FOLDER;
        $fileinfo_ = [];
        foreach ($files_ as $id => $val) {
            if (!$val->hasMoved()) {
                $val->move($filepath, $id . '.csv');
                $fileinfo_[$id] = new File($filepath . $id . '.csv');
            }
        }
        directory_mirror(self::UPLOAD_FOLDER, self::IMPORT_FOLDER, true);
        $this->testFiles();
        return $fileinfo_;
    }

    private function testFiles() {
        if (($open = fopen(self::IMPORT_FOLDER . "ipadt.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $ipadt[] = $data;
            }
            fclose($open);
        }
        print_r($ipadt);
        return die('This is testing function the testFiles!');
    }

    public function about() {
        return view(self::PAGES_FOLDER . 'aipn-about');
    }

    public function contact() {
        return view(self::PAGES_FOLDER . 'aipn-contact');
    }
}
