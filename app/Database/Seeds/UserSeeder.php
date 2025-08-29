<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'     => 'Admin User',
                'email'    => 'admin@example.com',
                'role'     => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
            ],
            [
                'name'     => 'Instructor One',
                'email'    => 'instructor1@example.com',
                'role'     => 'instructor',
                'password' => password_hash('teach123', PASSWORD_DEFAULT),
            ],
            [
                'name'     => 'Student One',
                'email'    => 'student1@example.com',
                'role'     => 'student',
                'password' => password_hash('stud123', PASSWORD_DEFAULT),
            ],
            [
                'name'     => 'Student Two',
                'email'    => 'student2@example.com',
                'role'     => 'student',
                'password' => password_hash('stud123', PASSWORD_DEFAULT),
            ],
        ];

        // Insert all users
        $this->db->table('users')->insertBatch($data);
    }
}
