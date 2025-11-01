<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Announcements extends Controller
{
    public function index()
    {
        $session = session();
        
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }
        
        return view('announcements');  // ← No folder, just filename
    }
}