<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');          // Homepage
$routes->get('about', 'Home::about');      // About
$routes->get('contact', 'Home::contact');  // Contact


$routes->get('/register', 'Auth::register');

$routes->post('/register', 'Auth::register');

$routes->get('/login', 'Auth::login');

$routes->post('/login', 'Auth::login');

$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Auth::dashboard');

$routes->get('/announcements', 'Announcements::index');

$routes->get('announcements', 'Announcements::index');

// Protected routes with RoleAuth filter
$routes->group('admin', ['filter' => 'roleauth'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
});

$routes->group('teacher', ['filter' => 'roleauth'], function($routes) {
    $routes->get('dashboard', 'Teacher::dashboard');
});

// You can add student routes here if needed in the future
$routes->group('student', ['filter' => 'roleauth'], function($routes) {
    // Add student-specific routes here
});
