<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\StudentModel;

class StudentController extends Controller {

    public function index() {
        return view('index');
    }

    public function importCsvToDb() {
        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
        ]);
        if (!$input) {
            $data['validation'] = $this->validator;
            return view('index', $data);
        } else {
            if ($file = $this->request->getFile('file')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('../public/csvfile', $newName);
                    $file = fopen("../public/csvfile/" . $newName, "r");
                    $i = 0;
                    $numberOfFields = 4;
                    $csvArr = array();

                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);
                        if ($i > 0 && $num == $numberOfFields) {
                            $csvArr[$i]['name'] = $filedata[0];
                            $csvArr[$i]['email'] = $filedata[1];
                            $csvArr[$i]['phone'] = $filedata[2];
                            $csvArr[$i]['created_at'] = $filedata[3];
                        }
                        $i++;
                    }
                    fclose($file);
                    $count = 0;
                    foreach ($csvArr as $userdata) {
                        $students = new StudentModel();
                        $findRecord = $students->where('email', $userdata['email'])->countAllResults();
                        if ($findRecord == 0) {
                            if ($students->insert($userdata)) {
                                $count++;
                            }
                        }
                    }
                    session()->setFlashdata('message', $count . ' rows successfully added.');
                    session()->setFlashdata('alert-class', 'alert-success');
                } else {
                    session()->setFlashdata('message', 'CSV file coud not be imported.');
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            } else {
                session()->setFlashdata('message', 'CSV file coud not be imported.');
                session()->setFlashdata('alert-class', 'alert-danger');
            }
        }
        return redirect()->route('/');
    }
}
