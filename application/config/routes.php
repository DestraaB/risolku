<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home'; // Arahkan ke katalog customer
$route['login'] = 'auth/index';
$route['logout'] = 'auth/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin/stok-beku'] = 'stock/frozen';
$route['admin/riwayat-stok'] = 'stock/history';
$route['cashier/open'] = 'cashier/open_stand';
$route['cashier/process-open'] = 'cashier/process_open_stand';
$route['admin/pengeluaran'] = 'finance/expenses';
$route['admin/tambah-pengeluaran'] = 'finance/add_expense';
$route['checkout'] = 'checkout/index';
$route['checkout/process'] = 'checkout/process';
$route['checkout/success/(:any)'] = 'checkout/success/$1';
$route['admin/orders'] = 'orders/index';
$route['admin/orders/detail/(:num)'] = 'orders/detail/$1';
$route['admin/orders/update/(:num)'] = 'orders/update_status/$1';
$route['admin/laporan'] = 'reports/index';
$route['admin/kasir'] = 'users/cashiers';
$route['admin/kasir/add'] = 'users/add_cashier';
$route['admin/kasir/toggle/(:num)'] = 'users/toggle_status/$1';
$route['admin/stok-stand'] = 'stock/stand';