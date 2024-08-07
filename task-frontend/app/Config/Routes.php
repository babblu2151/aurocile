<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');


$routes->get('courses', 'CourseController::index');
$routes->get('courses/create', 'CourseController::create');
$routes->get('courses/edit/(:num)', 'CourseController::edit/$1');

$routes->get('courses/(:num)/lessons', 'CourseController::lessons/$1');
$routes->get('courses/(:num)/lessons/create', 'CourseController::createLesson/$1');
$routes->get('courses/(:num)/lessons/edit/(:num)', 'CourseController::editLesson/$1/$2');
