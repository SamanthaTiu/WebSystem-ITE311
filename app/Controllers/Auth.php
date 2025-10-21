<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{
// Registration
public function register()
{
helper(['form']);
$session = session();

$db = \Config\Database::connect();

//

if (strtolower($this->request->getMethod()) === 'post') {
$rules = [
'name' => 'required|min_length[3]|max_length[50]',
'email' => 'required|valid_email',
'password' => 'required|min_length[6]',
'password_confirm' => 'matches[password]'
];

if (!$this->validate($rules)) {
return view('auth/register', ['validation' => $this->validator]);
}

$userModel = new UserModel();

// Check if email already exists
$existingUser = $userModel->where('email', $this->request->getPost('email'))->first();
if ($existingUser) {
$session->setFlashdata('error', 'Email already exists.');
return view('auth/register');
}

$data = [
'name' => $this->request->getPost('name'),
'email' => $this->request->getPost('email'),
'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
'role' => 'student',
];

// Try insert
if (!$userModel->insert($data)) {
// Show detailed DB/model errors
echo "<h3>⚠️ Registration Failed</h3>";
echo "<pre>";
print_r($userModel->errors()); // validation errors
print_r($userModel->db->error()); // database errors
echo "</pre>";
exit;
} 

$session->setFlashdata('success', 'Registration successful! Please log in.');
return redirect()->to(site_url('login'));
}

return view('auth/register');
}

// Login
public function login()
{
helper(['form']);
$session = session();
$userModel = new \App\Models\UserModel();

if (strtolower($this->request->getMethod()) === 'post') {
$rules = [
'email' => 'required|valid_email',
'password' => 'required|min_length[6]',
];

if (!$this->validate($rules)) {
return view('auth/login', ['validation' => $this->validator]);
}

$user = $userModel->where('email', $this->request->getPost('email'))->first();

if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
$session->set([
'user_id' => $user['user_id'],
'name' => $user['name'],
'email' => $user['email'],
'role' => $user['role'],
'isLoggedIn' => true,
]);

$session->setFlashdata('success', 'Welcome, ' . $user['name']);
return redirect()->to(site_url('dashboard'));
switch ($user['role']) {
                    case 'student':
                        return redirect()->to('/announcements');
                    case 'instructor':
                        return redirect()->to('/instructor/dashboard');
                    case 'admin':
                        return redirect()->to('/admin/dashboard');
                    default:
                        return redirect()->to('/dashboard');
                }
                return redirect()->to(site_url('dashboard'));
} else {
$session->setFlashdata('error', 'Invalid email or password.');
return redirect()->back();
}
}

return view('auth/login');
}

// Logout
public function logout()
{
session()->destroy();
return redirect()->to(site_url('login'));
}

// Dashboard
public function dashboard()
{
$session = session();
if (!$session->get('isLoggedIn')) {
return redirect()->to(site_url('login'));
}

return view('auth/dashboard', [
'name' => $session->get('name'),
'email' => $session->get('email'),
'role' => $session->get('role'),
]);
}
}