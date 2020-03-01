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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller']                    = 'dashboard';
$route['login']                                 = 'User_operation/login';
$route['logout']                                = 'User_operation/logout';
$route['login-check']                           = 'User_operation/do_login';
$route['404_override']                          = '';
$route['translate_uri_dashes']                  = FALSE;
$route['products/save-from-file']               = "products/save_from_file";
$route['products/create-product']               = "products/new_form";
$route['products/update-product/(.*)']          = "products/update_form/$1";
$route['purchases/add-purchase']                = "purchases/new_form";
$route['purchases/update-purchase/(.*)']        = "purchases/update_form/$1";
$route['suppliers/add-supplier']                = "suppliers/new_form";
$route['suppliers/update-supplier/(.*)']        = "suppliers/update_form/$1";
$route['customers/add-customer']                = "customers/new_form";
$route['customers/update-customer/(.*)']        = "customers/update_form/$1";
$route['billers/add-biller']                    = "billers/new_form";
$route['billers/update-biller/(.*)']            = "billers/update_form/$1";
$route['brands/add-brand']                      = "brands/new_form";
$route['brands/update-brand/(.*)']              = "brands/update_form/$1";
$route['categories/add-category']               = "categories/new_form";
$route['categories/update-category/(.*)']       = "categories/update_form/$1";
$route['sales/add-sale']                        = "sales/new_form";
$route['sales/update-sale/(.*)']                = "sales/update_form/$1";
$route['sales/invoice/(.*)']        			= "sales/makeInvoice/$1";
$route['recipes/add-recipe']                    = "recipes/new_form";
$route['recipes/update-recipe/(.*)']            = "recipes/update_form/$1";
$route['recipes/duplicate/(.*)']                = "recipes/duplicate_new_form/$1";
$route['machines/add-machine']                  = "machines/new_form";
$route['machines/update-machine/(.*)']          = "machines/update_form/$1";
$route['cigarette-types/getDataTable']          = "cigarette_types/getDataTable";
$route['cigarette-types']                       = "cigarette_types";
$route['cigarette-types/add-type']              = "cigarette_types/new_form";
$route['cigarette-types/update-ct/(.*)']        = "cigarette_types/update_form/$1";
$route['premixes/add-premix']                   = "premixes/new_form";
$route['premixes/update-premix/(.*)']           = "premixes/update_form/$1";
$route['tasks/add-task']                        = "tasks/new_form";
$route['tasks/add-task-log/(.*)']               = "tasks/saveTaskLog/$1";
$route['tasks/update-task/(.*)']                = "tasks/update_form/$1";
$route['units/add-unit']                        = "units/new_form";
$route['units/update-unit/(.*)']                = "units/update_form/$1";
$route['branches/add-branch']                   = "branches/new_form";
$route['branches/update-branch/(.*)']           = "branches/update_form/$1";
$route['departments/add-department']            = "departments/new_form";
$route['departments/update-department/(.*)']    = "departments/update_form/$1";
$route['warehouses/add-warehouse']              = "warehouses/new_form";
$route['warehouses/update-warehouse/(.*)']      = "warehouses/update_form/$1";
$route['item-handlings']                        = "item_handlings";


