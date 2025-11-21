<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_name' => 'Object-Oriented Programming',
                'description' => 'Learn OOP concepts in Java',
                'instructor_id' => 1,
            ],
            [
                'course_name' => 'Database Management Systems',
                'description' => 'Learn SQL, ERD, and relational databases',
                'instructor_id' => 2,
            ],
            [
                'course_name' => 'Data Structures & Algorithms',
                'description' => 'Learn arrays, linked lists, trees, graphs',
                'instructor_id' => 3,
            ],
            [
                'course_name' => 'Fundamentals of Networking',
                'description' => 'Learn LAN, WAN, TCP/IP, subnetting',
                'instructor_id' => 4,
            ],
            [
                'course_name' => 'Web Development 2 (PHP & Laravel)',
                'description' => 'Build dynamic web apps using Laravel',
                'instructor_id' => 5,
            ],
            [
                'course_name' => 'Mobile App Development',
                'description' => 'Build Android apps using Kotlin',
                'instructor_id' => 6,
            ],
        ];

        // Truncate table first to avoid duplicates
        $this->db->table('courses')->truncate();

        // Insert data into the courses table
        $this->db->table('courses')->insertBatch($data);
    }
}
