<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public
$routes->get('/', 'Home::index');
$routes->get('/tasks', 'TaskController::index');
$routes->get('/profile', 'UserController::index');
$routes->view('about', 'about');

// Auth
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

// Protected
$routes->group('tasks', ['filter' => \App\Filters\AuthFilter::class], static function ($routes) {
    $routes->get('new', 'TaskController::newTask');
    $routes->post('create', 'TaskController::create');
    $routes->get('(:num)/edit', 'TaskController::edit/$1');
    $routes->post('(:num)/update', 'TaskController::update/$1');
    $routes->post('(:num)/delete', 'TaskController::delete/$1');
});
