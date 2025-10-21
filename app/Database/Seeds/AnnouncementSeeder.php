<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Welcome to the New Student Portal',
                'content' => 'We are excited to announce the launch of our upgraded Online Student Portal!',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Midterm Exam Schedule',
                'content' => 'Midterm exams will start on November 5. Please check your class schedules for details.',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('announcements')->insertBatch($data);
    }
    }

