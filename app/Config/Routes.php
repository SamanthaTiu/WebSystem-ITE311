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

$routes->get('/announcements', 'Announcement::index');

$routes->get('/Instructor/dashboard', 'Instructor::dashboard');

$routes->get('/admin/dashboard', 'Admin::dashboard');

$routes->get('Instructor/dashboard', 'Instructor::dashboard');

$routes->get('admin/dashboard', 'Admin::dashboard');
