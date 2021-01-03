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

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['terms-condition'] = "terms_condition";
$route['contact-us'] = "contact_us";
$route['about-us'] = "about_us";

/*------------------------------ Auth rout ------------------------------*/
$route['admin'] = 'admin/auth/index';

$route['admin/do-login'] = 'admin/auth/doLogin';

$route['admin/forgot-password'] = 'admin/auth/forgotPassword';
$route['admin/do-forgot'] = 'admin/auth/do_forgotPassword';

$route['admin/reset-password/(:any)'] = 'admin/auth/resetPassword/$1';
$route['admin/do-resetpassword/(:any)'] = 'admin/auth/do_resetPassword/$1';

/*------------------------------ End Auth rout ------------------------------*/

/*------------------------------ Site setting  ------------------------------*/

$route['admin/site-setting'] = 'admin/site_settings/edit';
$route['admin/profile'] = 'admin/profile/edit/';
$route['admin/change-password'] = 'admin/change_password/create/';
$route['admin/google-analytics'] = 'admin/google_analytics/edit';

/*------------------------------ End Site setting  ------------------------------*/


/**---------------------------- News ------------------------------------------*/

$route['admin/news_image/index/(:num)/delete'] = 'admin/news_image/delete';
$route['admin/news_image/index/(:num)/bulk_delete'] = 'admin/news_image/bulk_delete';

/**---------------------------- End News ------------------------------------------*/


/*------------------------------ showcase Category  ------------------------------*/

$route['admin/showcase-category'] = 'admin/showcase_category/index';
$route['admin/showcase-category/create'] = 'admin/showcase_category/create';
$route['admin/showcase-category/edit/(:num)'] = 'admin/showcase_category/edit/$1';
$route['admin/showcase-category/delete'] = 'admin/showcase_category/delete';
$route['admin/showcase-category/bulk_delete'] = 'admin/showcase_category/bulk_delete';
$route['admin/showcase-category/is_active'] = 'admin/showcase_category/is_active';

/*------------------------------ End showcase Category  ------------------------------*/

/*------------------------------ Blog Category  ------------------------------*/

$route['admin/blog-category'] = 'admin/blog_category/index';
$route['admin/blog-category/create'] = 'admin/blog_category/create';
$route['admin/blog-category/edit/(:num)'] = 'admin/blog_category/edit/$1';
$route['admin/blog-category/delete'] = 'admin/blog_category/delete';
$route['admin/blog-category/bulk_delete'] = 'admin/blog_category/bulk_delete';
$route['admin/blog-category/is_active'] = 'admin/blog_category/is_active';

/*------------------------------ End Blog Category  ------------------------------*/

