    <?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'controllers/api/CommonAPI.php';


    class Master extends CommonAPI {

        function __construct() {
            parent::__construct();
            $this->load->library('pagination');
            $this->load->model('LastUpdatedSmsModal', 'last_updated_sms_modal');
            $this->load->model('PopularSmsModal', 'popular_sms_modal');
            $this->load->model('CategoryModal', 'category_modal');
            $this->load->model('SmsModal', 'sms_modal');
            $this->load->model('UserModal', 'user_modal');
            $this->load->model('FirebasePushNotification', 'firebase_push_notification');
        }

        public function sms_get() {
            $cat_id = $this->input->get(COL_CAT_ID);
            $page = $this->input->get(COL_PAGE);
            $login_user_id = $this->input->get(COL_USER_ID);
            if(empty($page) || $page==0){
                $page = 1;
            } 

            if(empty($cat_id) && $cat_id!=0){
                $this -> commonApiController(null, null, 422, "Parameter Missing.");
            } else {
                $messages = $this->sms_modal->get_sms($page, $cat_id, $login_user_id);
                if(empty($messages) && $page>1) {
                    $this -> commonApiController(null, null, 204, "No More Data.");
                } else {
                    $this -> commonApiController($messages);                    
                }
            }
        }

         public function register_post() {
            $post_data = $this->getPostParams();
            $user_display_name = $post_data[COL_USER_DISPLAY_NAME];
            $user_name = $post_data[COL_USER_NAME];
            $user_email = $post_data[COL_USER_EMAIL];
            $user_notification_token = $post_data[COL_USER_NOTIFICATION_TOKEN];

            if(empty($user_display_name) || empty($user_name) || empty($user_email) ){
                $this -> commonApiController(null, null, 422, "Parameter Missing.");
            } else {
                $user = $this->user_modal->register($user_display_name, $user_name, $user_email, $user_notification_token);
                print_r($this -> commonApiController($user));
            }
        }

        public function user_like_get() {
            $user_id = $this->input->get(COL_USER_ID);
			$user_likes = $this->user_modal->user_likes($user_id);
            $this -> commonApiController($user_likes);
        }

        public function like_post() {
            $post_data = $this->getPostParams();
            $user_id = $post_data[COL_USER_ID];
            $sms_id = $post_data[COL_SMS_ID];

            if(empty($user_id) || empty($sms_id)){
                $this -> commonApiController(null, null, 422, "Parameter Missing.");
            } else {
                $messages = $this->sms_modal->like_sms($user_id, $sms_id);
                $this -> commonApiController($messages);
            }
        }

        public function categories_get() {
            $p_id = $this->input->get(COL_P_ID);
            if(empty($p_id) && $p_id!=0){
                $this -> commonApiController(null, null, 422, "Parameter Missing.");
            } else {
                $categories = $this->category_modal->get_categories($p_id);
                if(empty($categories)){
                    $this -> commonApiController(null, null, 204, "Categories Not Found.");
                } else {
                    $this -> commonApiController($categories);
                }
            }
        }

         public function last_updated_sms_get() {
            $page = $this->input->get(COL_PAGE);
            $login_user_id = $this->input->get(COL_USER_ID);
            if(empty($page) || $page==0){
                $page = 1;
            } 
            $last_updated_sms = $this->last_updated_sms_modal->get_last_updated_sms($page, $login_user_id);
            $this -> commonApiController($last_updated_sms);
        }

        public function popular_sms_get() {
            $page = $this->input->get(COL_PAGE);
            $login_user_id = $this->input->get(COL_USER_ID);
            if(empty($page) || $page==0){
                $page = 1;
            } 
            $popular_sms = $this->popular_sms_modal->get_popular_sms($page, $login_user_id);
            $this -> commonApiController($popular_sms);
        }

        public function sendPushNotification_post() {
            $post_data = $this->getPostParams();
            $this->firebase_push_notification->sendNotifications($post_data);
        }


    }