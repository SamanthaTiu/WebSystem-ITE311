<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Course extends BaseController
{
    protected $enrollmentModel;
    protected $courseModel;
    protected $session;

    public function __construct()
    {
        $this->session = session();
        $this->enrollmentModel = new EnrollmentModel();
        $this->courseModel = new CourseModel();
    }

    /**
     * AJAX endpoint to enroll the current user into a course.
     * Expects POST: course_id
     * Returns JSON with appropriate HTTP status codes.
     */
    public function enroll()
    {
        // Get logged-in user id from session (adjust keys if your app uses different ones)
        $userId = $this->session->get('user_id') ?? $this->session->get('id');

        if (empty($userId)) {
            return $this->response
                        ->setStatusCode(401)
                        ->setJSON(['status' => 'error', 'message' => 'User not logged in']);
        }

        $courseId = (int) $this->request->getPost('course_id');
        if (empty($courseId)) {
            return $this->response
                        ->setStatusCode(400)
                        ->setJSON(['status' => 'error', 'message' => 'Missing course_id']);
        }

        // Verify course exists
        $course = $this->courseModel->find($courseId);
        if (empty($course)) {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON(['status' => 'error', 'message' => 'Course not found']);
        }

        // Prevent duplicate enrollment
        if ($this->enrollmentModel->isAlreadyEnrolled((int) $userId, $courseId)) {
            return $this->response
                        ->setStatusCode(409)
                        ->setJSON(['status' => 'error', 'message' => 'User already enrolled in this course']);
        }

        // Insert new enrollment
        $insertId = $this->enrollmentModel->enrollUser([
            'user_id' => (int) $userId,
            'course_id' => $courseId,
        ]);

        if ($insertId) {
            return $this->response
                        ->setStatusCode(201)
                        ->setJSON(['status' => 'success', 'message' => 'Enrolled successfully', 'enrollment_id' => $insertId]);
        }

        // fallback
        return $this->response
                    ->setStatusCode(500)
                    ->setJSON(['status' => 'error', 'message' => 'Failed to create enrollment']);
    }
}