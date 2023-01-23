<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of UserModel
 *
 * @author it
 */
class AipnModel extends Model {

    //put your code here
    public function facthExample() {
        $table = 'aipn_billitems';
        $an = '652225702';
        return $this->builder($table)
                        ->where('AN', $an)
                        ->get()
                        ->getResultArray();
    }

}
