<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    protected $userModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    public function dashboard()
    {
        $session = session();


        // Check if user is logged in and is an admin
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        if ($session->get('role') !== 'admin') {
            $session->setFlashdata('error', 'Access denied.');
            return redirect()->to(site_url('login'));
        }

        // Fetch recent registrations (last 10 users)
        $recentRegistrations = $this->userModel->orderBy('user_id', 'DESC')->findAll(10);

        // Pass data to the view
        $data = [
            'recentRegistrations' => $recentRegistrations
        ];

        // Load the admin dashboard view with data
        return view('admin/dashboard', $data);
    }

    public function manageUsers()
    {
        $session = session();

        // Check if user is logged in and is an admin
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to(site_url('login'));
        }

        // Fetch all users
        $users = $this->userModel->findAll();

        // Fetch user statistics
        $totalUsers = $this->userModel->countAll();
        $totalAdmins = $this->userModel->where('role', 'admin')->countAllResults();
        $totalTeachers = $this->userModel->where('role', 'instructor')->countAllResults();
        $totalStudents = $this->userModel->where('role', 'student')->countAllResults();

        $data = [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalTeachers' => $totalTeachers,
            'totalStudents' => $totalStudents
        ];

        return view('admin/manage_users', $data);
    }

    public function manageCourses()
    {
        $session = session();

        // Check if user is logged in and is an admin
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to(site_url('login'));
        }

        // Fetch all courses with instructor names
        $courses = $this->courseModel->select('courses.*, users.name as instructor_name')
            ->join('users', 'users.user_id = courses.instructor_id', 'left')
            ->findAll();

        // Fetch enrolled students for each course
        foreach ($courses as &$course) {
            $enrollments = $this->enrollmentModel->select('users.name as student_name')
                ->join('users', 'users.user_id = enrollments.user_id')
                ->where('enrollments.course_id', $course['course_id'])
                ->findAll();
            $course['enrolled_students'] = array_column($enrollments, 'student_name');
        }

        $data = [
            'courses' => $courses
        ];

        return view('admin/manage_courses', $data);
    }

    public function editUser($userId)
    {
        $session = session();

        // Check if user is logged in and is an admin
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to(site_url('login'));
        }

        // Fetch user data
        $user = $this->userModel->find($userId);
        if (!$user) {
            return redirect()->to(site_url('admin/manage-users'))->with('error', 'User not found');
        }

        // Prevent editing own account or other admin accounts
        if ($userId == $session->get('user_id') || $user['role'] === 'admin') {
            return redirect()->to(site_url('admin/manage-users'))->with('error', 'You cannot edit admin accounts or your own account');
        }

        $data = [
            'user' => $user
        ];

        return view('admin/edit_user', $data);
    }

    public function updateUser()
    {
        $session = session();

        // Check if user is logged in and is an admin
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to(site_url('login'));
        }

        $userId = $this->request->getPost('user_id');

        // Prevent updating own account or other admin accounts
        if ($userId == $session->get('user_id')) {
            return redirect()->to(site_url('admin/manage-users'))->with('error', 'You cannot edit your own account');
        }

        $user = $this->userModel->find($userId);
        if ($user && $user['role'] === 'admin') {
            return redirect()->to(site_url('admin/manage-users'))->with('error', 'You cannot edit admin accounts');
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $role = $this->request->getPost('role');

        // Map "teacher" to "instructor" for database consistency
        if ($role === 'teacher') {
            $role = 'instructor';
        }

        // Update user
        $this->userModel->update($userId, [
            'name' => $name,
            'email' => $email,
            'role' => $role
        ]);

        return redirect()->to(site_url('admin/dashboard'))->with('success', 'User updated successfully');
    }

    public function restrictUser($userId)
    {
        $session = session();

        // Check if user is logged in and is an admin
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to(site_url('login'));
        }

        // Restrict user (e.g., change role to 'restricted')
        $this->userModel->update($userId, ['role' => 'restricted']);

        return redirect()->to(site_url('admin/dashboard'))->with('success', 'User restricted successfully');
    }

    public function deleteUser($userId)
    {
        $session = session();

        // Check if user is logged in and is an admin
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to(site_url('login'));
        }

        // Delete user
        $this->userModel->delete($userId);

        return redirect()->to(site_url('admin/dashboard'))->with('success', 'User deleted successfully');
    }
}
