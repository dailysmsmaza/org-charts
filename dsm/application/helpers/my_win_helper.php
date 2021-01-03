<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_css')) {

    /**
     * Create a link from a js array or string
     * HTTP_ASSETS_PATH_ADMIN_CSS set a base path of js folder ex assets/client/js admin or client as u want
     * @param Array $css accept a array
     * @param Sting $css accept a  signal string
     * @param String $prifix use both of them admin and client admin/client as u want
     * @return void
     */
    function get_css($css = NULL, $prifix = 'client') {
        // $CI =& get_instance();
        $get_css = "";
        //$path  = ($prifix == 'admin') ? HTTP_ASSETS_PATH_ADMIN_CSS : HTTP_ASSETS_PATH_CLIENT_CSS ;
        $ci = & get_instance();
        $ci->config->load('assets', TRUE);
        $path = $ci->config->item($prifix);


        if (isset($css) && !empty($css) && !is_null($path)) {
            if (is_array($css)) {
                foreach ($css as $css_key => $css_value) {
                    $get_css .= '<link rel="stylesheet" href="' . base_url() . $path . $css_value . '" type="text/css">' . "\n";
                }
            } else {
                $get_css .= '<link rel="stylesheet" href="' . base_url() . $path . $css . '" type="text/css">' . "\n";
            }
        }
        return $get_css;
    }

}


if (!function_exists('get_js')) {

    /**
     * Create a link from a js array or string
     * HTTP_ASSETS_PATH_ADMIN_JS set a base path of js folder ex assets/client/js admin or client as u want
     * @param Array $js accept a array
     * @param Sting $js accept a  signal string
     * @param String $prifix use both of them admin and client admin/client as u want
     * @return void
     */
    function get_js($js = NULl, $prifix = 'client') {
        // $CI =& get_instance();
        $get_js = "";
        //$path  = ($prifix == 'admin') ? HTTP_ASSETS_PATH_ADMIN_JS : HTTP_ASSETS_PATH_CLIENT_JS ;
        $ci = & get_instance();
        $ci->config->load('assets', TRUE);
        $path = $ci->config->item($prifix);
        if (isset($js) && !empty($js)) {
            if (is_array($js)) {
                foreach ($js as $js_key => $js_value) {
                    $get_js .= '<script src="' . base_url() . $path . trim($js_value) . '"></script>' . "\n";
                }
            } else {
                $get_js .= '<script src="' . base_url() . $path . trim($js) . '"></script>' . "\n";
            }
        }
        return $get_js;
    }

}


if (!function_exists('get_input')) {

    /**
     * When server side validation is used , redirect to curent page to refill to input value to used
     * postdata key to use a session
     * @param String $key input name
     * @param string $default input defalult value
     */
    function get_input($key = NULl, $default = '') {
        $ci = & get_instance();
        $ci->load->library('session');


        $poatdata = $ci->session->flashdata('postdata');

        if (array_key_exists($key, $ci->input->post())) {
            return $ci->input->post($key);
        }

        if ($key !== NULL AND ! empty($poatdata)) {
            if (array_key_exists($key, $poatdata)) {
                return $poatdata[$key];
            }
        }

        return $default;
    }

}


if (!function_exists('get_checkbox')) {

    /**
     * Rechecked a check box
     * @param String $key input name
     * @param string $value checkbox box value
     * @return void
     */
    function get_checkbox($key = NULl, $value = '', $default = '') {

        $ci = & get_instance();
        $ci->load->library('session');
        $poatdata = $ci->session->flashdata('postdata');

        if ($default) {
            return "checked";
        }

        if (!isset($poatdata[$key]) && !isset($_POST[$key])) {
            return FALSE;
        }

        if ((is_array($poatdata[$key]) && in_array($value, $poatdata[$key], TRUE) ) OR isset($_POST[$key])) {
            return "checked";
        } else {
            if ($key !== NULL AND ! empty($poatdata)) {
                if (array_key_exists($key, $poatdata) AND $poatdata[$key] !== "" AND ! is_array($poatdata[$key])) {
                    return "checked";
                }
            }
        }
        /** if $default is true then is checked */
        return $default;
    }

}


if (!function_exists('has_error')) { /**
 * Check a server side form validation and input need to display a error
 * @param  String $key as input name
 * @param  String $default
 * @return NUll
 */

    function has_error($key = NULl, $default = NULL) {
        $ci = & get_instance();
        $ci->load->library('session');
        $errors = $ci->session->flashdata('error');

        if (is_array($errors) && !empty($errors)) {
            if (array_key_exists($key, $errors)) {
                return $errors[$key];
            }
        }
        return $default;
    }

}


if (!function_exists('display_flash')) {

    /**
     * Get a flash message from name
     * @param String $name
     * @return void
     */
    function display_flash($name) {
        $CI = & get_instance();
        if ($CI->session->flashdata($name)) {
            $flash = $CI->session->flashdata($name);
            if (is_array($flash['message'])) {
                $msg = '<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-' . $flash['message_type'] . ' alert-dismissible fade show" role="alert">
				<div class="m-alert__icon"> <i class="la la-info-circle"></i> </div>
				<div class="m-alert__text">';
                foreach ($flash['message'] as $flash_message) {
                    $msg .= $flash_message . '<br />';
                }
                return $msg . '</div>
				<div class="m-alert__close">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
				</div>
				</div>';
            } else {
                return '<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-' . $flash['message_type'] . ' alert-dismissible fade show" role="alert"> <div class="m-alert__icon"> <i class="la la-info-circle"></i> </div> <div class="m-alert__text"> ' . $flash['message'] . '</div> <div class="m-alert__close"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button> </div> </div>';
            }
        }
    }

}

if (!function_exists('set_flash')) {

    /**
     * set a falsh message
     * @param String $name
     * @param String $message_type calss name ex danger,success,info,warning
     * @param String $message Only singale OR multipal as array message
     * @param Array  $message Only singale string OR multipal as array message
     * @return void
     */
    function set_flash($name, $message_type, $message) {
        $CI = & get_instance();
        $CI->session->set_flashdata($name, array('message_type' => $message_type, 'message' => $message));
    }

}

if (!function_exists('is_menu_active')) {

    /**
     * Set a active class fore curen controller
     * @param String $controller
     * @return void
     */
    function is_menu_active($controller, $class = NUll) {
        $CI = & get_instance();

        if (is_array($controller) && in_array($CI->router->fetch_class(), $controller)) {
            $controller_class = $CI->router->fetch_class();
            return ($controller_class == array_key_exists($controller_class, $controller)) ? config_item('active_class') . ' ' . $class : '';
        }

        $controller_class = $CI->router->fetch_class();


        return ($controller_class == $controller) ? config_item('active_class') . ' ' . $class : '';
    }

}

if (!function_exists('get_subnav')) {

    /**
     * Set a active class fore curen controller
     * @param String $controller
     * @return void
     */
    function get_subnav($method, $text = NUll) {
        $CI = & get_instance();
        $controller_class = $CI->router->fetch_class();
        $li = '
		<li class="m-menu__item " aria-haspopup="true">
		<a href="' . base_url('admin/' . $method) . '" class="m-menu__link ">
		<i class="m-menu__link-bullet m-menu__link-bullet--dot"> <span></span> </i> <span class="m-menu__link-text text-capitalize">' . $text . ' </span> 
		</a>
		</li>
		';
        return $li;
    }

}


if (!function_exists('get_subnav')) {

    /**
     * Set a active class fore curen controller
     * @param String $controller
     * @return void
     */
    function get_nav($text, $text = NUll) {
        $CI = & get_instance();
        $controller_class = $CI->router->fetch_class();
        $li = '
		<a href="#" class="m-menu__link m-menu__toggle">
			<i class="m-menu__link-icon flaticon-user"></i> 
			<span class="m-menu__link-text">Users <span class="m-menu__link-badge pull-right"> <span class="m-badge m-badge--danger"> 2 </span> </span>  
			</span> 
			<i class="m-menu__ver-arrow la la-angle-right"></i>         
		</a>';
        return $li;
    }

}


if (!function_exists('is_active')) {

    /**
     * Set a active in grid
     * @param String $is_active is a string array of id and activer 
     * @return void
     */
    function is_active($row, $method = "is_active") {
        if ($row['is_active'] == 1) {
            return '<div class="text-center">
								<span class="m-switch m-switch--icon  text-center m-switch--success m-switch--sm">
									<label>
										<input type="checkbox" class="gridTable-is-active" data-method="' . $method . '" data-active="1" checked="checked" value="' . $row['id'] . '" name="display_isactive_' . $row['id'] . '">
										<span></span>
									</label>
								</span>
							</div>';
        } else {
            return '<div class="text-center">
								<span class="m-switch m-switch--icon  m-switch--success m-switch--sm">
									<label>
										<input type="checkbox" class="gridTable-is-active" data-method="' . $method . '" data-active="0" name="display_isactive_' . $row['id'] . '" value="' . $row['id'] . '">
										<span></span>
									</label>
								</span>
							</div>';
        }
    }

}

if (!function_exists('get_delete_all')) {

    /**
     * Set a active in grid
     * @param String $_id is id of curent row 
     * @return void
     */
    function get_delete_all($_id) {
        return '<label class="m-checkbox m-checkbox--single p-0 m-checkbox--all m-checkbox--solid m-checkbox--brand">
							<input type="checkbox" name="delete_all[]" value="' . $_id . '" data-uid="' . $_id . '"><span class="mt-2"></span>
						</label>';
    }

}

if (!function_exists('get_edit')) {

    /**
     * Set a active in grid
     * @param String $_id is id of curent row 
     * @return void
     */
    function get_edit($_id, $url) {

        return "<div class='text-center'>
							<a class='btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill' href='" . base_url($url) . "/" . $_id . "'><i class='fa fa-3x fa-pencil'></i>
							</a>
						</div>";
    }

}

if (!function_exists('get_delete')) {

    /**
     * Set a active in grid
     * @param String $_id is id of curent row 
     * @return void
     */
    function get_delete($_id) {
        return '<div class="text-center">
							<a class="btn btn-danger gridTable-delete btn-sm  m-btn m-btn--icon  m-btn--icon-only m-btn--custom m-btn--pill"
							 data-uid="' . $_id . '" href="javascript:void(0)" data-method="delete" ><i class="fa fa-3x fa-trash"></i>
							</a>
						</div>';
    }

}

if (!function_exists('get_image_path')) {

    /**
     * Set a active in grid
     * @param String $_id is id of curent row 
     * @return void
     */
    function get_image_path($partner_image_path, $width = 50) {

        return "<div class='w-" . $width . " mx-auto'>
							<img class='image-admin-display w-100'  src=" . base_url() . trim($partner_image_path, './') . ">
						</div>";
    }

}

if (!function_exists('get_display_order')) {

    /**
     * Set a active disply order
     * @param String $_id is id of curent row 
     * @return void
     */
    function get_display_order($display_order) {
        return "<div class='m-form__control form-inline w-75 m-auto'>
							 <input type='text' class='form-control w-50 text-center' maxlength='2' value='" . $display_order['display_order'] . "'
								name='display_order_id[]' id='display_order_" . $display_order['id'] . "' onKeyPress='return numericOnly(this);' />
								<input type='hidden' value='" . $display_order['id'] . "' name='hid_table_id[]' id='hid_table_id_" . $display_order['id'] . "' />
							</div>";
    }

}
if (!function_exists('get_format_date')) {

    /**
     * Set a date formate
     * @param array $_data is array of curent row or data 
     * @return void
     */
    function get_format_date($date) {
        if ($date['date_format'] == "0000-00-00") {
            return '<div class="text-center"></div>';
        } else {
            return '<div class="text-center">' . date("d M Y", strtotime($date['date_format'])) . '</div>';
        }
    }

}

if (!function_exists('get_view')) {
    /* set view link */

    function get_view($id, $url) {
        return "<div class='text-center'><a class='btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill' href='" . base_url($url) . "/" . $id . "'><i class='fa fa-3x fa-eye'></i></a></div>";
    }

}
if (!function_exists('get_total_image_count')) {
    /* set total image count row wise */

    function get_total_image_count($image_count) {
        return "<div class='text-center'><a style='position: relative;' href='" . base_url() . $image_count["url_path"] . $image_count["id"] . "'><img width='700px' class='fa fa-fw' src='" . base_url() . "assets/admin/images/camera38.png' style='width: 35px;'/> <span class='badge'>" . $image_count["image_count"] . "</span></a></div>";
    }

}
if (!function_exists('get_media')) {

    function get_media($news_media_path, $width) {

        $media = explode('#', $news_media_path);

        if ($media[3] == 1) {
            return "<div class='text-center'><img src=" . base_url() . $media[0] . " class='w-" . $width . "'></div>";
        } else if ($media[3] == 2) {
            return "<div class='text-center admin-embedcode'>" . $media[1] . "</div>";
        } else if ($media[3] == 3) {
            return "<div class='text-center'><video controls='controls' preload='none' name='media' class='admin-grid-img'><source src='" . base_url() . $media[2] . "'  type='video/mp4'></video></div>";
        }
    }

}
if (!function_exists('get_is_status')) {

    function get_is_status($is_status) {
        if ($is_status == 1) {
            return "<div class='text-center'>Sent</div>";
        } else {
            return "<div class='text-center'>Draft</div>";
        }
    }

}
if (!function_exists('getCategorybyImages')) {

    function getCategorybyImages($id) {
        $CI = & get_instance();
        $CI->db->where('category_id', $id);
        $CI->db->where('is_active', 1);
        $CI->db->order_by('display_order', 'asc');
        $result = $CI->db->get('showcase');
        return $result->result_array();
    }
    

}

if (!function_exists('social_media')) {
    function social_media() {
        $CI = & get_instance();
        $CI->db->where('is_active', 1);
//        $CI->db->order_by('display_order', 'asc');
        $result = $CI->db->get('social_media');
        return $result->result_array();
    }
}
if (!function_exists('google_analytics')) {
    function google_analytics() {
        $CI = & get_instance();
         $CI->db->where('id', 1);
        $result = $CI->db->get('google_analytics');
        return $result->row();
    }
    
    

}