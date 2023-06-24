<?php
/**
 * @link https://www.positronx.io/codeigniter-import-csv-file-data-to-mysql-database-tutorial/ Codeigniter 4 Import CSV Data to MySQL Database Tutorial
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStudents extends Migration {

    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'create_at' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('students');
    }

    public function down() {
        $this->forge->dropTable('students');
    }
}
