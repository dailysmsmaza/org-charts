<?php
// DB SETTINGS
define('HOSTNAME', 'localhost');
define('USERNAME', 'dailysms_dsmuser');
define('PASSWORD', 'RVTzHBX.D;XK');
define('DATABASE_NAME', 'dailysms_expense_manager');
//--------------


// TABLE DATA
define('TBL_USERS', 'users');
define('TBL_PASSWORD_RESET', 'password_reset');
define('TBL_CATEGORY', 'category');
define('TBL_USER_CATEGORY', 'user_category');
define('TBL_USER_SETTINGS', 'user_settings');
define('TBL_USER_EXPENSE', 'user_expense');

// --------------

// COMMON COLUMNS
define('COL_ID', 'id');
define('COL_PASSWORD', 'password'); // TBL_USERS, TBL_PASSWORD_RESET
// --------------

// COLUMNS : TBL_USERS
define('COL_NAME', 'name');
define('COL_EMAIL', 'email');
define('COL_MOBILE_NUMBER', 'mobile_number');
define('COL_IS_PASSCODE', 'is_passcode');
define('COL_IS_REGISTER', 'is_register');
define('COL_NOTIFICATION_TOKEN', 'notification_token');
// --------------

// COLUMNS : TBL_PASSWORD_RESET
define('COL_USER_ID', 'user_id');
// --------------

// COLUMNS : TBL_PASSWORD_RESET
define('COL_CAT_NAME', 'cat_name');
define('COL_CAT_DESCRIPTION', 'cat_description');
define('COL_IMG_URL', 'cat_img_url');
// --------------

// COLUMNS : TBL_PASSWORD_RESET
define('COL_CAT_ID', 'cat_id');
define('COL_REMAINING_LIMIT', 'remaining_limit');
define('COL_MONTHLY_LIMIT', 'monthly_limit');
// --------------

// COLUMNS : TBL_USER_SETTINGS
define('COL_REPORT_MONTHLY', 'report_monthly');
define('COL_NOTIFICATION', 'notification');
define('COL_LANGUAGE', 'language');
// --------------

// COLUMNS : TBL_USER_EXPENSE
define('COL_TITLE', 'title');
define('COL_PRICE', 'price');
define('COL_DESCRIPTION', 'description');
define('COL_LOCATION', 'location');
define('COL_IS_ONLINE', 'is_online');
// --------------




defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



/*
* ----------------------------------------- client css and js ----------------------------------------- 
*/
defined('HTTP_ASSETS_PATH_CLIENT_CSS') OR define('HTTP_ASSETS_PATH_CLIENT_CSS', 'assets/client/css/'); 
defined('HTTP_ASSETS_PATH_CLIENT_JS') OR define('HTTP_ASSETS_PATH_CLIENT_JS', 'assets/client/js/'); 

/*
* ----------------------------------------- admin css and js -----------------------------------------
*/
defined('HTTP_ASSETS_PATH_ADMIN_CSS') OR define('HTTP_ASSETS_PATH_ADMIN_CSS', 'assets/admin/base/'); 
defined('HTTP_ASSETS_PATH_ADMIN_JS') OR define('HTTP_ASSETS_PATH_ADMIN_JS', 'assets/admin/base/');

/*
* ----------------------------------------- Display order is active or not -----------------------------------------
*/
defined('DISPLAY_ORDER') OR define('DISPLAY_ORDER',TRUE) ;