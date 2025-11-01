<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use CodeIgniter\Controller;

class Course extends Controller
{
    public function enroll()
    {
        // Expect a POST (AJAX) request
        $request = service('request');
        $response = service('response');
        $session = session();

        // If you want to allow non-AJAX POSTs, remove the isAJAX check
        if (!$request->isAJAX()) {
            return $response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request type.'
            ]);
        }

        $user_id = $session->get('user_id');
        if (!$user_id) {
            return $response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in.'
            ]);
        }

        $course_id = $request->getPost('course_id');
        if (!$course_id) {
            return $response->setJSON([
                'status' => 'error',
                'message' => 'Course ID is required.'
            ]);
        }

        $enrollmentModel = new EnrollmentModel();

        if ($enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $response->setJSON([
                'status' => 'error',
                'message' => 'You are already enrolled in this course.'
            ]);
        }

        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrollment_date' => date('Y-m-d H:i:s'),
        ];

        $insertId = $enrollmentModel->enrollUser($data);

        if ($insertId) {
            return $response->setJSON([
                'status' => 'success',
                'message' => 'Enrollment successful.',
                'enrollment_id' => $insertId
            ]);
        } else {
            return $response->setJSON([
                'status' => 'error',
                'message' => 'Enrollment failed. Try again.'
            ]);
        }
    }
}