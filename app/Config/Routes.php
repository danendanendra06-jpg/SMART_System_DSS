<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

// Auth
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/processLogin', 'Auth::processLogin');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/processRegister', 'Auth::processRegister');
$routes->get('auth/reset_password', 'Auth::reset_password');
$routes->post('auth/processReset', 'Auth::processReset');
$routes->get('auth/logout', 'Auth::logout');

// Protected Routes (must be logged in)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    
    $routes->get('home', 'Home::index');

    // Admin Only
    $routes->group('', ['filter' => 'admin'], static function ($routes) {
        // Kriteria View & CRUD (Only Admin manages Kriteria)
        $routes->get('smart/kriteria', 'Smart::kriteria');
    });

    // Alternatif CRUD (Global for User to add, Admin to monitor/delete)
    $routes->get('alternatif', 'Alternatif::index');
    $routes->get('alternatif/search', 'Alternatif::search');
    $routes->get('alternatif/create', 'Alternatif::create');
    $routes->post('alternatif/store', 'Alternatif::store');
    $routes->get('alternatif/edit/(:num)', 'Alternatif::edit/$1');
    $routes->post('alternatif/update/(:num)', 'Alternatif::update/$1');
    $routes->delete('alternatif/delete/(:num)', 'Alternatif::delete/$1');

    // Penilaian CRUD (User can rate)
    $routes->get('penilaian', 'Penilaian::index');
    $routes->get('penilaian/create', 'Penilaian::create');
    $routes->post('penilaian/store', 'Penilaian::store');
    $routes->get('penilaian/edit/(:num)', 'Penilaian::edit/$1');
    $routes->post('penilaian/update/(:num)', 'Penilaian::update/$1');
    $routes->delete('penilaian/delete/(:num)', 'Penilaian::delete/$1');

    // User Only Bobot Setting
    $routes->get('userbobot', 'UserBobot::index');
    $routes->post('userbobot/store', 'UserBobot::store');

    // Smart Method Steps (Available for both Admin & User, logic differs inside)
    $routes->get('smart/penilaian', 'Smart::penilaian');
    $routes->get('smart/rata-rata', 'Smart::rata_rata');
    $routes->get('smart/rata_rata', 'Smart::rata_rata'); 
    $routes->get('smart/normalisasi', 'Smart::normalisasi');
    $routes->get('smart/utility', 'Smart::utility');
    $routes->get('smart/nilai-akhir', 'Smart::nilai_akhir');
    $routes->get('smart/nilai_akhir', 'Smart::nilai_akhir'); 
    $routes->get('smart/ranking', 'Smart::ranking');

    // Feedback
    $routes->post('feedback/submit', 'Feedback::submit');
    $routes->get('feedback/admin', 'Feedback::admin');

});
