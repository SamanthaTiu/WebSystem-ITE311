<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Instructor extends BaseController
{
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    public function dashboard()
    {
        $session = session();

        // Check if user is logged in and is a teacher
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        if ($session->get('role') !== 'instructor') {
            $session->setFlashdata('error', 'Access denied.');
            return redirect()->to(site_url('login'));
        }

        $userId = $session->get('user_id');
        $courses = $this->courseModel->where('instructor_id', $userId)->findAll();

        // Load the teacher dashboard view with courses data
        return view('instructor/dashboard', ['courses' => $courses]);
    }

    public function courses()
    {
        $session = session();

        if (!$session->get('isLoggedIn') || $session->get('role') !== 'instructor') {
            return redirect()->to(site_url('login'));
        }

        $userId = $session->get('user_id');
        $courses = $this->courseModel->where('instructor_id', $userId)->findAll();

        return view('instructor/course/courses', ['courses' => $courses]);
    }

    public function my_students()
    {
        $session = session();

        if (!$session->get('isLoggedIn') || $session->get('role') !== 'instructor') {
            return redirect()->to(site_url('login'));
        }

        $userId = $session->get('user_id');
        $students = $this->enrollmentModel->select('enrollments.*, courses.course_name, users.name as student_name, users.email as student_email')
            ->join('courses', 'courses.course_id = enrollments.course_id')
            ->join('users', 'users.user_id = enrollments.user_id')
            ->where('courses.instructor_id', $userId)
            ->findAll();

        return view('instructor/my_students', ['students' => $students]);
    }

    public function manageCourse($courseId)
    {
        $session = session();

        if (!$session->get('isLoggedIn') || $session->get('role') !== 'instructor') {
            return redirect()->to(site_url('login'));
        }

        $userId = $session->get('user_id');

        // Fetch course owned by instructor
        $course = $this->courseModel->where('course_id', $courseId)->where('instructor_id', $userId)->first();

        if (!$course) {
            return redirect()->to(site_url('instructor/courses'))->with('error', 'Course not found or access denied');
        }

        // Render manage course view
        return view('instructor/course/manage_courses', ['course' => $course]);
    }
}
