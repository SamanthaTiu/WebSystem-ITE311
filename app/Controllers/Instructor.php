<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Instructor extends BaseController
{
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
        
        // Load the teacher dashboard view
        return view('instructor/dashboard');
    }
}
