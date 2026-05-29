<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Alternatif CRUD
$routes->get('alternatif', 'Alternatif::index');
$routes->get('alternatif/create', 'Alternatif::create');
$routes->post('alternatif/store', 'Alternatif::store');
$routes->get('alternatif/edit/(:num)', 'Alternatif::edit/$1');
$routes->post('alternatif/update/(:num)', 'Alternatif::update/$1');
$routes->delete('alternatif/delete/(:num)', 'Alternatif::delete/$1');

// Responden CRUD
$routes->get('responden', 'Responden::index');
$routes->get('responden/create', 'Responden::create');
$routes->post('responden/store', 'Responden::store');
$routes->get('responden/edit/(:num)', 'Responden::edit/$1');
$routes->post('responden/update/(:num)', 'Responden::update/$1');
$routes->delete('responden/delete/(:num)', 'Responden::delete/$1');

// Penilaian CRUD
$routes->get('penilaian', 'Penilaian::index');
$routes->get('penilaian/create', 'Penilaian::create');
$routes->post('penilaian/store', 'Penilaian::store');
$routes->get('penilaian/edit/(:num)', 'Penilaian::edit/$1');
$routes->post('penilaian/update/(:num)', 'Penilaian::update/$1');
$routes->delete('penilaian/delete/(:num)', 'Penilaian::delete/$1');

// Smart Method Steps
$routes->get('smart/kriteria', 'Smart::kriteria');
$routes->get('smart/penilaian', 'Smart::penilaian');
$routes->get('smart/rata-rata', 'Smart::rata_rata');
$routes->get('smart/rata_rata', 'Smart::rata_rata'); // duplicate for safety due to links
$routes->get('smart/normalisasi', 'Smart::normalisasi');
$routes->get('smart/utility', 'Smart::utility');
$routes->get('smart/nilai-akhir', 'Smart::nilai_akhir');
$routes->get('smart/nilai_akhir', 'Smart::nilai_akhir'); // duplicate for safety
$routes->get('smart/ranking', 'Smart::ranking');


