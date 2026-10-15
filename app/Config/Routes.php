
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Existing pages
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('customers', 'Home::customers');
$routes->get('users', 'Home::users');
$routes->get('email', 'Home::email');

// Singular aliases for the customer and user directories.
$routes->get('customer', 'Home::customers');
$routes->get('user', 'Home::users');

// Customer account routes
$routes->get('customers/new', 'Home::newCustomer');
$routes->post('customers/create', 'Home::createCustomer');

$routes->get('customers/edit/(:num)', 'Home::editCustomer/$1');
$routes->post('customers/update/(:num)', 'Home::updateCustomer/$1');

// User account routes
$routes->get('users/new', 'Home::newUser');
$routes->post('users/create', 'Home::createUser');

$routes->get('users/edit/(:num)', 'Home::editUser/$1');
$routes->post('users/update/(:num)', 'Home::updateUser/$1');
