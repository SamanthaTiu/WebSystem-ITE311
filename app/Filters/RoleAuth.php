<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }
        
        // Get user role and current URI
        $role = $session->get('role');
        $uri = $request->getUri()->getPath();
        
        // Admin can access anything starting with /admin
        if ($role === 'admin' && strpos($uri, 'admin') !== false) {
            return;
        }
        
        // Teacher can only access routes starting with /teacher
        if ($role === 'teacher' && strpos($uri, 'teacher') !== false) {
            return;
        }
        
        // Student can access /student routes and /announcements
        if ($role === 'student') {
            if (strpos($uri, 'student') !== false || strpos($uri, 'announcements') !== false) {
                return;
            }
        }
        
        // If none of the above conditions are met, deny access
        $session->setFlashdata('error', 'Access Denied: Insufficient Permissions');
        return redirect()->to(base_url('announcements'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after the request
    }
}