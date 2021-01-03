    <?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'controllers/api/CommonAPI.php';


    class Master extends CommonAPI {

        function __construct() {
            parent::__construct();
            $this->load->library('pagination');
            $this->load->model('UserModal', 'user_modal');
            $this->load->model('CategoryModal', 'category_modal');
            $this->load->model('ExpenseModal', 'expense_modal');
            $this->load->model('FirebasePushNotification', 'firebase_push_notification');
        }


        // USERS MODAL
        public function is_registered_post() {
            $post_data = $this->getPostParams();
            $is_exist = $this->user_modal->user_exist($post_data);
            $is_register = $post_data["is_register"];
            if($is_register==1){ // If Register Api 
                if($is_exist){
                    $this -> commonApiController(null, null, 208, "Account Already Exists.");

                } else {
                    $this -> commonApiController(null, null, 200, "Account Not Exists.");
                }

            } else { // If Forgot Password Api
                if($is_exist){
                    $this -> commonApiController(null, null, 200, "Account Already Exists.");

                } else {
                    $this -> commonApiController(null, null, 409, "Account Not Found.");
                }
            }
        }

        public function register_post() {
            $post_data = $this->getPostParams();
            $is_exist = $this->user_modal->user_exist($post_data);
            if($is_exist){
                $this -> commonApiController(null, null, 208, "Account Already Exists.");

            } else {
                $user = $this->user_modal->insert_user($post_data);
                $this -> commonApiController($user);
            }

        }
        public function login_post() {
            $post_data = $this->getPostParams();
            $user = $this->user_modal->login($post_data);
            if(empty($user)){
                if($this->user_modal->user_exist($post_data)){
                    $this -> commonApiController(null, null, 401, "Email/PhoneNumber and Password does not match...");
                } else {
                    $this -> commonApiController(null, null, 409, "Account Not Found.");
                }
            } else {
                $this -> commonApiController($user);
            }
        }
        public function update_user_post() {
            $post_data = $this->getPostParams();
            $user = $this->user_modal->update_user($post_data);
            $this -> commonApiController($user);
        }
        public function change_password_post() {
            $post_data = $this->getPostParams();
            $is_exist = $this->user_modal->user_exist($post_data);
            if($is_exist){
                $already_used = $this->user_modal->check_password_already_used($post_data);
                if($already_used){
                    $this -> commonApiController(null, null, 208, "Password Already Used Before.");
                } else {
                    $user = $this->user_modal->change_password($post_data);
                    $this -> commonApiController($user);
                }
            } else {
                $this -> commonApiController(null, null, 409, "Account Not Found.");
            }
        }

        public function update_user_settings_post() {
            $post_data = $this->getPostParams();
            $user = $this->user_modal->update_user_settings($post_data);
            $this -> commonApiController($user);
        }

        public function get_user_settings_get() {
            $user_id = $this->input->get(COL_USER_ID);
            $user = $this->user_modal->get_user_settings($user_id);
            $this -> commonApiController($user);
        }

        // ------------------

        // Category Modal
        public function category_get() {
            $user_id = $this->input->get(COL_USER_ID);
            $category = $this->category_modal->categories($user_id);
            if(empty($category)){
                $this -> commonApiController(null, null, 409, "Category Not Found.");
            } else {
                $this -> commonApiController($category);
            }
        }
        public function add_user_categories_post() {
            $post_data = $this->getPostParams();
            $user_categories = $this->category_modal->add_user_category($post_data);
            $this -> commonApiController($user_categories);
        }

        public function get_user_categories_get(){
            $user_id = $this->input->get(COL_USER_ID);
            $user_categories = $this->category_modal->get_user_category_data($user_id);
            $this -> commonApiController($user_categories);
        }
        // ------------------

        // Expense Modal
        public function add_expense_post(){
            $expense = $this->expense_modal->add_user_expense();
            // $this -> commonApiController($expense);
        }
        // -------------------

        public function sendPushNotification_post() {
            $post_data = $this->getPostParams();
            $this->firebase_push_notification->sendNotifications($post_data);
        }


    }