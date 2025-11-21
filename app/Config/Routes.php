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

$routes->get('/announcements', 'Announcements::index');

$routes->get('announcements', 'Announcements::index');

$routes->get('/instructor/dashboard', 'Instructor::dashboard');

$routes->get('/admin/dashboard', 'Admin::dashboard');

$routes->post('/course/enroll', 'Course::enroll'); // AJAX endpoint for enrollment

// Use Dashboard::index for /dashboard to load courses and enrollments
$routes->get('/dashboard', 'Dashboard::index');

// My Courses page
$routes->get('/my-courses', 'Dashboard::myCourses');

// My Grades page
$routes->get('/my-grades', 'Dashboard::myGrades');
