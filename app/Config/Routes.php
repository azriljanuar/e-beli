<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/master', 'Items::index');
$routes->post('/master/save', 'Items::save');
$routes->get('/master/delete/(:num)', 'Items::delete/$1');
$routes->get('/transaction', 'Transactions::index');
$routes->post('/transaction/save', 'Transactions::save');
$routes->get('/transaction/delete/(:segment)', 'Transactions::delete/$1');

$routes->get('/expenses', 'Expenses::index');
$routes->post('/expenses/save', 'Expenses::save');
$routes->get('/expenses/delete/(:num)', 'Expenses::delete/$1');

$routes->get('/recap', 'Recap::index');
$routes->get('/recap/download', 'Recap::downloadPdf');
