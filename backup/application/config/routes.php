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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login';
$route['signup'] = 'login/singupuser';
$route['user'] = 'user';
$route['company'] = 'company';
$route['employee'] = 'employee';
$route['testimonial'] = 'testimonial';
$route['setting'] = 'setting';
$route['requestfeedback'] = 'requestfeedback';
$route['givefeedback'] = 'givefeedback';
$route['givefeedback/receviedfeedback'] = 'givefeedback/receviedfeedback';
$route['contact'] = 'home/contact';
$route['department'] = 'department';
$route['department/(:num)/create-orgchart'] = 'department/create_orgchart/$1';
$route['company/department/(:num)'] = 'company/department/$1';
$route['company/department/(:num)/add'] = 'company/add_department/$1';
$route['company/department/(:num)/edit/(:num)'] = 'company/department_edit/$1/$2';

$route['(:any)'] = 'home/orgchart/$1';
$route['(:any)/team/(:any)'] = 'home/department_orgchart/$1/$2';
$route['(:any)/downloadorgchart'] = 'home/download_orgchart/$1';
$route['(:any)/team/(:any)/downloadteamorgchart'] = 'home/downloaddept_orgchart/$1/$2';
//$route['(:any)/department/(:any)'] = 'home/department_orgchart/$1/$2';
$route['sharepdf/(:num)/(:any)'] = 'home/sharepdf/$1/$2';
//$route['sharepdf/(:any)/(:num)'] = 'home/sharepdf/$1/$2';
$route['sharepdf_department/(:num)/(:any)/(:num)/(:any)'] = 'home/sharepdf_department/$1/$2/$3/$4';

$route['department/subteam/(:any)'] = 'department/subteam/$1';
//$route['department/subteam/(:any)/add_subteam'] = 'department/add_subteam/$1';
$route['department/subteam/(:any)/add_subteam'] = 'department/add_subteam/$1';
$route['department/subteam/(:any)/edit_subteam/(:num)'] = 'department/edit_subteam/$1/$2';
$route['company/department/(:num)/subteam/(:num)'] = 'company/subteam/$1/$2';
$route['company/department/(:num)/subteam/(:num)/add_subteam'] = 'company/add_subteam/$1/$2';
$route['company/department/(:num)/subteam/(:num)/edit_subteam/(:num)'] = 'company/edit_subteaminadmin/$1/$2/$3';