<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
    
    private static $API_SERVER_KEY = 'Your Server Key';
    private static $is_background = "TRUE";
   
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper');
                $this->load->helper('sms_helper');
                $this->load->model("Web_model");  
    }
    function signout(){
        $this->session->sess_destroy();
        redirect("admin");
    }
    public function index()
    {
        // if(_is_user_login($this)){
        //     redirect(_get_user_redirect($this));
        // }else{
            
            $data = array("error"=>"");       
            if(isset($_POST))
            {
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                   if($this->form_validation->error_string()!=""){
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
                }else
                {
                   
                $q = $this->db->query("Select * from `users` where (`user_email`='".$this->input->post("email")."')
                 and user_password='".md5($this->input->post("password"))."' and user_login_status='1'");
                    
                   // print_r($q) ; 
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->user_status == "0")
                        {
                            $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Your account currently inactive.</div>';
                        }
                        else
                        {
                            $newdata = array(
                                                   'user_name'  => $row->user_fullname,
                                                   'user_email' => $row->user_email,
                                                   'logged_in' => TRUE,
                                                   'user_id'=>$row->user_id,
                                                   'user_type_id'=>$row->user_type_id
                                                  );
                            $this->session->set_userdata($newdata);
                            redirect(_get_user_redirect($this));
                         
                        }
                    }
                    else
                    {
                        $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Invalid User and password. </div>';
                    }
                   
                    
                }
            }
            else
            {
                $this->session->sess_destroy();
            }
            $data["active"] = "login";
            
            $this->load->view("admin/login2",$data);
        // }
    }
    public function dashboard(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $date = date("Y-m-d");
            $data["today_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$date."' ");
             $nexday = date('Y-m-d', strtotime(' +1 day'));
            $data["nextday_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$nexday."' ");
            $this->load->view("admin/dashboard",$data);
        }
        else{
            redirect("admin");
        }
    }
    public function orders(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");  
            $fromdate = date("Y-m-d");
            $todate = date("Y-m-d");
            $data['date_range_lable'] = $this->input->post('date_range_lable');
           
             $filter = "";
            if($this->input->post("date_range")!=""){
                $filter = $this->input->post("date_range");
                $dates = explode(",",$filter);                
                $fromdate =  date("Y-m-d", strtotime($dates[0]));
                $todate =  date("Y-m-d", strtotime($dates[1])); 
                $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' ";
            }
            $data["today_orders"] = $this->product_model->get_sale_orders($filter);
            $data["dboy"] = $this->product_model->getDeliveryBoy();
            
            $this->load->view("admin/orders/orderslist2",$data);
        }
        else{
            redirect("admin");
        }
    }
    public function confirm_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 1 where sale_id = '".$order_id."'");
                 $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                                $message["title"] = "Confirmed  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' confirmed successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order confirmed. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }
    
    
    
    public function assign_delivery_boy(){
        
        
      
        if(_is_user_login($this)){
               $id =  $this->uri->segment(3);
         $order_id =  $this->uri->segment(4);
         $DeliveryBoy  =  $this->uri->segment(5);
         
         
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
               
                
                $q = $this->db->query("Update sale  SET assign_to = $id , status = '1' , DeliveryBoy = '".$DeliveryBoy."' WHERE sale_id = $order_id ");
             //   $user = $q->row();
                
                     
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Successful </strong>  deliverey Boy Assign. </div>');
              
            }
           // header('Location: https://www.layaji.in/admin/orders');
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }
    
    public function delivered_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 2 where sale_id = '".$order_id."'");
                /* $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
                where sale_id = '".$order_id."'"); 

                */
                
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                        $message["title"] = "Delivered  Order";
                        $message["message"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s"); 
                        $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }
    
    public function delivered_order_complete($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 4 where sale_id = '".$order_id."'");
                $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
                where sale_id = '".$order_id."'"); 

                
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();

                $q2 = $this->db->query("Select total_rewards, user_id from sale where sale_id = '".$order_id."'");
                $user2 = $q2->row();
                        
                        $rewrd_by_profile=$user->rewards;
                        $rewrd_by_order=$user2->total_rewards;

                        $new_rewards=$rewrd_by_profile+$rewrd_by_order;
                        $this->db->query("update registers set rewards = '".$new_rewards."' where user_id = '".$user2->user_id."'");

                        $message["title"] = "Delivered  Order";
                        $message["message"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s");
                        $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }

    public function cancle_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            
            if(!empty($order)){
                $this->db->query("update sale set status = 3 where sale_id = '".$order_id."'");
                $this->db->delete('sale_items', array('sale_id' => $order_id)); 
                
                 $q = $this->db->query("Select * from users where user_id = '".$order->user_id."'");  
                 $user = $q->row();  
                                $message["title"] = "Cancel  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' cancel successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order Cancle. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }
    
    public function delete_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("delete from sale where sale_id = '".$order_id."'");
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order deleted. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }

    public function orderdetails($order_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $data["order"] = $this->product_model->get_sale_order_by_id($order_id);
            $data["order_items"] = $this->product_model->get_sale_order_items($order_id);
            $img = $this->db->query("select * from signature where order_id='".$order_id."'");
            
            if(count($img->result())==0)
            {
                $data["signature"] = array('signature'=>'N/A');
                // echo "na";
            }
            else
            {
                $d=$img->row();
                $data["signature"] = array('signature'=>$d->signature);
                // echo "yes".count($img->result());
            }
            // var_dump($data["signature"]);
            // //print_r( $data);exit();
            $this->load->view("admin/orders/orderdetails2",$data);
        }
        else{
            redirect("admin");
        }
    }

    public function change_status(){
        $table = $this->input->post("table");
        $id = $this->input->post("id");
        $on_off = $this->input->post("on_off");
        $id_field = $this->input->post("id_field");
        $status = $this->input->post("status");
        
        $this->db->update($table,array("$status"=>$on_off),array("$id_field"=>$id));
    }
/*=========USER MANAGEMENT==============*/   
    public function user_types(){
        $data = array();
        if(isset($_POST))
            {
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                   if($this->form_validation->error_string()!=""){
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
                }else
                {
                        $user_type = $this->input->post("user_type");
                        
                            $this->load->model("common_model");
                            $this->common_model->data_insert("user_types",array("user_type_title"=>$user_type));
                            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Type added Successfully
                                </div>') ;
                             redirect("admin/user_types/");   
                        
                }
            }
        
        $this->load->model("users_model");
        $data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_types",$data);
    }

    function user_type_delete($type_id){
        $data = array();
            $this->load->model("users_model");
            $usertype  = $this->users_model->get_user_type_id($type_id);
           if($usertype){
                $this->db->query("Delete from user_types where user_type_id = '".$usertype->user_type_id."'");
                redirect("admin/user_types");
           }
    }

    public function user_access($user_type_id){
        if($_POST){
           //print_r($_POST);     
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type_id', 'User Type', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                   if($this->form_validation->error_string()!=""){
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                 }
                }else{
                    //$user_type_id = $this->input->post("user_type_id");
                    $this->load->model("common_model");
                    $this->common_model->data_remove("user_type_access",array("user_type_id"=>$user_type_id));
                    
                    $sql = "Insert into user_type_access(user_type_id,class,method,access) values";
                    $sql_insert = array();
                    foreach(array_keys($_POST["permission"]) as $controller){
                        foreach($_POST["permission"][$controller] as $key=>$methods){
                            if($key=="all"){
                                $key = "*";
                            }
                            $sql_insert[] = "($user_type_id,'$controller','$key',1)";
                        }
                    }
                    $sql .= implode(',',$sql_insert)." ON DUPLICATE KEY UPDATE access=1";
                    $this->db->query($sql);
                }
        }
        $data['user_type_id'] = $user_type_id;
        $data["controllers"] = $this->config->item("controllers");
        $this->load->model("users_model");
        $data["user_access"] = $this->users_model->get_user_type_access($user_type_id);
        
        //$data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_access",$data);
    }
/*============USRE MANAGEMENT===============*/

  
/* ========== Categories =========== */
    public function addsubcategories($id)
    {
       if(_is_user_login($this)){
           
          //  $data["error"] = "";
           // $data["active"] = "addcat";
             $data = $id;
            if(isset($_REQUEST["addsubcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->add_subcategory(); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/addcategories');
                }
            }
        $this->load->view('admin/categories/sub_addcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
     public function addcategories()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->add_category(); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/addcategories');
                }
            }
        $this->load->view('admin/categories/addcat2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function add_header_categories()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->add_header_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/add_header_categories');
                }
            }
        $this->load->view('admin/icon_categories/addcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function editcategory($id)
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->edit_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/listcategories');
                }
            }
           $this->load->view('admin/categories/editcat2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
     public function edit_header_category($id)
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `header_categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->edit_header_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/header_categories');
                }
            }
           $this->load->view('admin/icon_categories/editcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function listcategories()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listcat";
           $this->load->model("category_model");
           $data["allcat"] = $this->category_model->get_categories();
           $this->load->view('admin/categories/listcat2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function header_categories()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listcat";
           $this->load->model("category_model");
           $data["allcat"] = $this->category_model->get_header_categories();
           $this->load->view('admin/icon_categories/listcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function deletecat($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/listcategories');
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_header_categories($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("header_categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/header_categories');
        }
        else
        {
            redirect('admin');
        }
    }

      
/* ========== End Categories ========== */  
/* ========== Commision ========== */ 
public function listcommision()
    {
         if(_is_user_login($this)){
            
                if(isset($_POST))
                {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('category', 'category', 'trim|required');
                    $this->form_validation->set_rules('commision', 'Commision Percent', 'trim|required');

                    if ($this->form_validation->run() == FALSE)
                    {
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    }
                    else
                    {
                  
                        $this->load->model("common_model");
                        $array = array(
                        "category_name"=>$this->input->post("category"),
                        "commision_percent"=>$this->input->post("commision")

                        );
                        $this->common_model->data_insert("commision",$array);
                        
                        $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect("admin/listcommision");
                    }
                    
                    $this->load->model("product_model");
                    $data["commisions"]  = $this->product_model->get_commision();
                    $this->load->view("admin/commision/listcommision",$data);  
                    
                }
        }
        else
        {
            redirect('admin');
        }
    }

public function edit_commision($id){
        if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('category', 'category', 'trim|required');
                $this->form_validation->set_rules('commision', 'Commision Percent', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "category_name"=>$this->input->post("category"),
                    "commision_percent"=>$this->input->post("commision")

                    );
                    $this->common_model->data_update("commision",$array,array("id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/listcommision");
                }
                
                $this->load->model("product_model");
                $data["commision"]  = $this->product_model->get_commision_by_id($id);
                $this->load->view("admin/commision/editcommision",$data);  
                
            }
        }
        else
        {
            redirect('admin');
        }
        
    }
    public function delete_commision($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from commision where id = '".$id."'");
            redirect("admin/listcommision");
        }
        else
        {
            redirect('admin');
        }
    }
/* ========== End Commision ========== */ 
  
/* ========== Products ==========*/
function products(){
    if(_is_user_login($this)){
        $this->load->model("product_model");
        $data["products"]  = $this->product_model->get_products();
        $this->load->view("admin/product/list2",$data);
    }
    else
    {
        redirect('admin');
    }
}
 
 function header_products(){
        $this->load->model("product_model");
        $data["products"]  = $this->product_model->get_header_products();
        $this->load->view("admin/icon_product/list",$data);    
}

function edit_products($prod_id){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {


                    if($this->input->post("rewards")=="")
                    {
                        $rewards=0;
                    }
                    else
                    {
                        $rewards=$this->input->post("rewards");
                    }
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "product_arb_name"=>$this->input->post("arb_prod_title"), 
                    "product_arb_description"=>$this->input->post("arb_product_description"),
                    "category_id"=>$this->input->post("parent"), 
                    "product_description"=>$this->input->post("product_description"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "price"=>$this->input->post("price"),
                    "mrp"=>$this->input->post("mrp"),
                    "tax"=>$this->input->post("tax"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"),
                    "arb_unit"=>$this->input->post("arb_unit"), 
                    "rewards"=>$rewards
                    
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_update("products",$array,array("product_id"=>$prod_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/products');
                }
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_product_by_id($prod_id);
            $this->load->view("admin/product/edit2",$data);
        }
        else
        {
            redirect('admin');
        }
    
}

function edit_header_products($prod_id){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"), 
                    "product_description"=>$this->input->post("product_description"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"),
                    "rewards"=>$this->input->post("rewards")
                    
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_update("header_products",$array,array("product_id"=>$prod_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
                }
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_header_product_by_id($prod_id);
            $this->load->view("admin/icon_product/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    
}

function add_products(){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                 $this->form_validation->set_rules('price', 'price', 'trim|required');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required'); 
                $this->form_validation->set_rules('mrp', 'mrp', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    if($this->input->post("rewards")=="")
                    {
                        $rewards=0;
                    }
                    else
                    {
                        $rewards=$this->input->post("rewards");
                    }
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "product_arb_name"=>$this->input->post("arb_prod_title"), 
                    "product_arb_description"=>$this->input->post("arb_product_description"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "product_description"=>$this->input->post("product_description"),
                    "price"=>$this->input->post("price"),
                    "mrp"=>$this->input->post("mrp"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                    "arb_unit"=>$this->input->post("arb_unit"), 
                    "tax"=>$this->input->post("tax"), 
                    "rewards"=>$rewards
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $in_id = $this->common_model->data_insert("products",$array); 
                    $purchaasr=$this->db->query("Insert into purchase(product_id, qty, unit, date, store_id_login) values('".$in_id."', 1, '".$this->input->post("unit")."', '".date('d-m-y h:i:s ')."', '"._get_current_user_id($this)."')");
                    if($purchaasr){ $m=1; }else{ $m=0; }
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully..."'.$m.'"
                                    </div>');
                    redirect('admin/products');
                }
            }
            
            $this->load->view("admin/product/add2");
        }
        else
        {
            redirect('admin');
        }
    
}

function add_header_products(){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                 $this->form_validation->set_rules('price', 'price', 'trim|required');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "product_description"=>$this->input->post("product_description"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                    "rewards"=>$this->input->post("rewards")
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_insert("header_products",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
                }
            }
            
            $this->load->view("admin/icon_product/add");
        }
        else
        {
            redirect('admin');
        }
    
}

function delete_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from products where product_id = '".$id."'");
            redirect("admin/products");
        }
        else
        {
            redirect('admin');
        }
        
}

function delete_header_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from header_products where product_id = '".$id."'");
            redirect("admin/header_products");
        }
}

/* ========== Products ==========*/  
/* ========== Purchase ==========*/
public function add_purchase(){
    if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }
                
                $this->load->model("product_model");
                $data["purchases"]  = $this->product_model->get_purchase_list();
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/purchase2",$data);  
                
            }
    }
    else
    {
        redirect('admin');
    }
    
}

function edit_purchase($id){
    if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit")
                    );
                    $this->common_model->data_update("purchase",$array,array("purchase_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }
                
                $this->load->model("product_model");
                $data["purchase"]  = $this->product_model->get_purchase_by_id($id);
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/edit_purchase2",$data);  
                
            }
    }
    else
    {
        redirect('admin');
    }
}

function delete_purchase($id){
    if(_is_user_login($this)){
        $this->db->query("Delete from purchase where purchase_id = '".$id."'");
        redirect("admin/add_purchase");
    }
    else
    {
        redirect('admin');
    }
}
/* ========== Purchase END ==========*/
    public function socity(){
        if(_is_user_login($this)){
            
                if(isset($_POST))
                {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                    $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                     $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

                    if ($this->form_validation->run() == FALSE)
                    {
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    }
                    else
                    {
                  
                        $this->load->model("common_model");
                        $array = array(
                        "socity_name"=>$this->input->post("socity_name"),
                        "pincode"=>$this->input->post("pincode"),
                          "delivery_charge"=>$this->input->post("delivery")

                        );
                        $this->common_model->data_insert("socity",$array);
                        
                        $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect("admin/socity");
                    }
                    
                    $this->load->model("product_model");
                    $data["socities"]  = $this->product_model->get_socities();
                    $this->load->view("admin/socity/list2",$data);  
                    
                }
        }
        else
        {
            redirect('admin');
        }
            
    }

    public function city(){
        if(_is_user_login($this)){


            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city_name', 'City Name', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "city_name"=>$this->input->post("city_name")
                    );
                    $this->common_model->data_insert("city",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/city");
                } 
                
            }
        
            $ct  = $this->db->query("select * from `city`");
            $data["cities"] = $ct->result();
            $this->load->view("admin/socity/city_list",$data);  
        }
        else{
            redirect("admin");
        }
        
    }

    public function delete_city($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from city where city_id = '".$id."'");
            redirect("admin/city");
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function declared_rewards(){
        if(_is_user_login($this)){
            
                $this->load->library('form_validation');
               $this->load->model("product_model");
               
                   
                    
                     $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

                    if (!$this->form_validation->run() == FALSE)
                    {
                        
                        $point = array(
                           'point' => $this->input->post('delivery')
                          
                        );
                        
                        $this->product_model->update_reward($point);
                        
                        
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    
                    
                   }
                    
                    $data['rewards']  = $this->product_model->rewards_value();
                    //print_r( $data['rewards']);
                    $this->load->view("admin/declared_rewards/edit2",$data);  
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function edit_socity($id){
        if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "socity_name"=>$this->input->post("socity_name"),
                    "pincode"=>$this->input->post("pincode"),
                       "delivery_charge"=>$this->input->post("delivery")

                    );
                    $this->common_model->data_update("socity",$array,array("socity_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/socity");
                }
                
                $this->load->model("product_model");
                $data["socity"]  = $this->product_model->get_socity_by_id($id);
                $this->load->view("admin/socity/edit2",$data);  
                
            }
        }
        else
        {
            redirect('admin');
        }
        
    }
    public function delete_socity($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from socity where socity_id = '".$id."'");
            redirect("admin/socity");
        }
        else
        {
            redirect('admin');
        }
    }

    function registers(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $users = $this->product_model->get_all_users();
            $this->load->view("admin/allusers2",array("users"=>$users));
        }
        else
        {
            redirect('admin');
        }
    }
 
 /* ========== Page app setting =========*/
public function addpage_app()
    {
       if(_is_user_login($this))
       {
           
            $data["error"] = "";
            $data["active"] = "addpageapp"; 
            
            if(isset($_REQUEST["addpageapp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page  Title', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("page_app_model");
                    $this->page_app_model->add_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Page added successfully...</div>');
                    redirect('admin/addpage_app');
                }

            }
            $this->load->view('admin/page_app/addpage_app',$data);
        }
        else
        {
            redirect('login');
        }
    }
    
    public function allpageapp()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["allpages"] = $this->page_app_model->get_pages();
           
           $this->load->view('admin/page_app/allpage_app2',$data);
        }
        else
        {
            redirect('login');
        }
    }
    public function editpage_app($id)
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["onepage"] = $this->page_app_model->one_page($id);
           
           if(isset($_REQUEST["savepageapp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('page_id', 'Page Id', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("page_app_model");
                    $this->page_app_model->set_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page saved successfully...</div>');
                    redirect('admin/allpageapp');
                }
            }
           $this->load->view('admin/page_app/editpage_app2',$data);
        }
        else
        {
            redirect('login');
        }
    }
    public function deletepageapp($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("pageapp",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page deleted successfully...
                                    </div>');
            redirect('admin/allpage_app');
        }
        else
        {
            redirect('login');
        }
    }

/* ========== End page page setting ========*/

public function setting(){
    if(_is_user_login($this)){
          $this->load->model("setting_model"); 
                $data["settings"]  = $this->setting_model->get_settings(); 
              
                $this->load->view("admin/setting/settings2",$data);  
    }
    else
    {
        redirect('admin');
    }
}

public function edit_settings($id){
    if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                 
                $this->form_validation->set_rules('value', 'Amount', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "title"=>$this->input->post("title"), 
                    "value"=>$this->input->post("value")
                    );
                    
                    $this->common_model->data_update("settings",$array,array("id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/setting");
                }
                
                $this->load->model("setting_model");
                $data["editsetting"]  = $this->setting_model->get_setting_by_id($id);
                $this->load->view("admin/setting/edit_settings2",$data);  
                
            }
    }
    else
        {
            redirect('admin');
        }
}
    
public function stock(){
    if(_is_user_login($this)){
        $this->load->model("product_model");
        $data["stock_list"] = $this->product_model->get_leftstock();
        $this->load->view("admin/product/stock2",$data);
    }
    else
        {
            redirect('admin');
        }
}
/* ========== End page page setting ========*/
   function testnoti(){
        $token =  "dLmBHiGL_6g:APA91bGp5L_mZ0NwPZiihxIDVmo-d-UV05fvmcIDzDiyJ82ztCelmFl4oFRD2hEOPT2lE--ze-yH6Nac6KxbHspYWSQw4mmw8AZ-3HRrwD_crCO1o3p9mRu9WvOOsaw_vvScMnIIv2np";
    }

    function notification(){
        if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('descri', 'Description', 'trim|required');
                  if ($this->form_validation->run() == FALSE)
                  {
                              if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                  }else{
                            // $message["title"] = 'Minerva Grocery';
                            $message= $this->input->post("descri");
                            ///$message["created_at"] = date("Y-m-d h:i:s");
                            
                            //$msg = $this->input->post("descri");
                            
                            $message=array('title' => 'Minerva Grocery', 'body' => $message ,'sound'=>'Default','image'=>'Notification Image' );
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            //$result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
                            
                            //$result = $gcm->send_topics("Minerva_Grocery",$message ,"android");
                            //$result = $gcm->send_notification("Minerva_Grocery", $message,"android");
                            
                                                                        $q = $this->db->query("Select user_ios_token from registers");
                                                                        $registers = $q->result();
                                                                  foreach($registers as $regs){
                                                                         if($regs->user_ios_token!=""){
                                                                                 $registatoin_ids[] = $regs->user_ios_token;
                                                                                 $result = $gcm->send_notification($regs->user_ios_token, $message,"android");
                                                                         }
                                                                  }
                    //  if(count($registatoin_ids) > 1000){
                      
                    //   $chunk_array = array_chunk($registatoin_ids,1000);
                    //   foreach($chunk_array as $chunk){
                    //     $result = $gcm->send_notification($chunk, $message,"android");
                    //   }
                      
                    //  }
                    //  else{
    
                    //   //$result = $gcm->send_notification($registatoin_ids, $message,"android");
                    //     }  
                            
                             redirect("admin/notification");
                  }
                   
                   $this->load->view("admin/product/notification2");
                
            }
        }
        else
        {
            redirect('admin');
        }
        
    }
    
    function time_slot(){
        if(_is_user_login($this)){
                $this->load->model("time_model");
                $timeslot = $this->time_model->get_time_slot();
                
                $this->load->library('form_validation');
                $this->form_validation->set_rules('opening_time', 'Opening Hour', 'trim|required');
                $this->form_validation->set_rules('closing_time', 'Closing Hour', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
                  if(empty($timeslot)){
                    $q = $this->db->query("Insert into time_slots(opening_time,closing_time,time_slot) values('".date("H:i:s",strtotime($this->input->post('opening_time')))."','".date("H:i:s",strtotime($this->input->post('closing_time')))."','".$this->input->post('interval')."')");
                  }else{
                    $q = $this->db->query("Update time_slots set opening_time = '".date("H:i:s",strtotime($this->input->post('opening_time')))."' ,closing_time = '".date("H:i:s",strtotime($this->input->post('closing_time')))."',time_slot = '".$this->input->post('interval')."' ");
                  }  
                }            
            
            $timeslot = $this->time_model->get_time_slot();
            $this->load->view("admin/timeslot/edit2",array("schedule"=>$timeslot));
        }
        else
        {
            redirect('admin');
        }
    }

    function closing_hours(){
        if(_is_user_login($this)){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
                    $this->form_validation->set_rules('opening_time', 'Start Hour', 'trim|required');
                    $this->form_validation->set_rules('closing_time', 'End Hour', 'trim|required');
                    if ($this->form_validation->run() == FALSE)
                    {
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    }
                    else
                    {
                          $array = array("date"=>date("Y-m-d",strtotime($this->input->post("date"))),
                          "from_time"=>date("H:i:s",strtotime($this->input->post("opening_time"))),
                          "to_time"=>date("H:i:s",strtotime($this->input->post("closing_time")))
                          ); 
                          $this->db->insert("closing_hours",$array); 
                    }
            
             $this->load->model("time_model");
             $timeslot = $this->time_model->get_closing_date(date("Y-m-d"));
             $this->load->view("admin/timeslot/closing_hours2",array("schedule"=>$timeslot));
        }
        else
        {
            redirect('admin');
        }
            
    }
    
     
    function delete_closing_date($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from closing_hours where id = '".$id."'");
            redirect("admin/closing_hours");
        }
        else
        {
            redirect('admin');
        }
    }

    public function addslider()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("slider",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/addslider');
                }
            }
        $this->load->view('admin/slider/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
 
    public function listslider()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->get_slider();
           $this->load->view('admin/slider/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    
    public function add_Banner()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("banner",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/add_Banner');
                }
            }
        $this->load->view('admin/banner/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function banner()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->banner();
           $this->load->view('admin/banner/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function edit_banner($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_banner($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_banner($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/banner');
                }
            }
           $this->load->view('admin/banner/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function editslider($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_slider_by_id($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_slider($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/listslider');
                }
            }
           $this->load->view('admin/slider/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function deleteslider($id){

        if(_is_user_login($this))
        {
            $data = array();
            $this->load->model("slider_model");
            $slider  = $this->slider_model->get_slider_by_id($id);
            if($slider){
                $this->db->query("Delete from slider where id = '".$slider->id."'");
                unlink("uploads/sliders/".$slider->slider_image);
                redirect("admin/listslider");
           }
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_banner($id){
        if(_is_user_login($this))
        {
            $data = array();
            $this->db->query("Delete from banner where id = '".$id."'");
            unlink("uploads/sliders/".$slider->slider_image);
            redirect("admin/banner");
        }
        else
        {
            redirect('admin');
        }   
           
    }
    
    public function coupons(){
        if(_is_user_login($this)){
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');
            
            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            $data['coupons'] = $this->product_model->coupon_list();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">not wor', '</div>');
                
                $this->load->view("admin/coupons/coupon_list2",$data); 
                 
            }
            else{
                $data = array(
                'coupon_name'=>$this->input->post('coupon_title'),
                'coupon_code'=> $this->input->post('coupon_code'),
                'valid_from'=> $this->input->post('from'),
                'valid_to'=> $this->input->post('to'),
                'validity_type'=> $this->input->post('product_type'),
                'product_name'=> $this->input->post('printable_name'),
                'discount_type'=> $this->input->post('discount_type'),
                'discount_value'=> $this->input->post('value'),
                'cart_value'=> $this->input->post('cart_value'),
                'uses_restriction'=> $this->input->post('restriction')
                 );
                 //print_r($data);
                 if($this->product_model->coupon($data))
                 {
                     $this->session->set_flashdata('addmessage','Coupon added Successfully.');
                    $data['coupons'] = $this->product_model->coupon_list();
                    $this->load->view("admin/coupons/coupon_list2",$data);
                 }
            }
        }
        else
        {
            redirect('admin');
        }
        
    }  

    public function add_coupons(){
        if(_is_user_login($this))
        {
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');
            
            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            $data['coupons'] = $this->product_model->coupon_list();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">not wor', '</div>');
                
                $this->load->view("admin/coupons/add_coupons",$data); 
                 
            }else{
                $data = array(
                'coupon_name'=>$this->input->post('coupon_title'),
                'coupon_code'=> $this->input->post('coupon_code'),
                'valid_from'=> $this->input->post('from'),
                'valid_to'=> $this->input->post('to'),
                'validity_type'=> "",
                'product_name'=> "",
                'discount_type'=> "",
                'discount_value'=> $this->input->post('value'),
                'cart_value'=> $this->input->post('cart_value'),
                'uses_restriction'=> $this->input->post('restriction')
                 );
                 //print_r($data);
                 if($this->product_model->coupon($data))
                 {
                     $this->session->set_flashdata('addmessage','Coupon added Successfully.');
                    $data['coupons'] = $this->product_model->coupon_list();
                    $this->load->view("admin/coupons/add_coupons",$data);
                 }
            }
        }
    } 

    public function date_valid($date)
    {
        $parts = explode("/", $date);
        if (count($parts) == 3) {      
            if (checkdate($parts[1], $parts[0], $parts[2]))
            {
                return TRUE;
            }
        }
        $this->form_validation->set_message('date_valid', 'The Date field must be dd/mm/yyyy');
        return false;
    }

    function lookup(){  
        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        if($type=='Category')
        {
            
        } 
        elseif ($type=='Sub Category') {
            
        }
        else{
            $query = $this->product_model->lookup($keyword); //Search DB 
        }
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->product_name 
                                         
                                     );  //Add a row to array  
            }  
        }
        //print_r( $data['message']);
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }  
    
    function looku(){

        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        
            $query = $this->product_model->looku($keyword); //Search DB 
        
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->title 
                                         
                                     );  //Add a row to array  
            }  
        }
        //print_r( $data['message']);
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }

    function look(){

        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        if($type=='Category')
        {
            
        } 
        elseif ($type=='Sub Category') {
            
        }
        else{
            $query = $this->product_model->look($keyword); //Search DB 
        }
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->title 
                                         
                                     );  //Add a row to array  
            }  
        }
        //print_r( $data['message']);
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }

    function editCoupon($id){
        if(_is_user_login($this)){
            //echo $id;die();
            $this->load->helper('form');
            $this->load->library('form_validation');
           
            $this->load->model('product_model');

            $this->load->model('product_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');

            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
                $data['coupon'] = $this->product_model->getCoupon($id);
                $this->load->view("admin/coupons/edit_coupon",$data); 
                 
            }
            else{
                $data = array(
                'coupon_name'=>$this->input->post('coupon_title'),
                'coupon_code'=> $this->input->post('coupon_code'),
                'valid_from'=> $this->input->post('from'),
                'valid_to'=> $this->input->post('to'),
                'validity_type'=> "",
                'product_name'=> "",
                'discount_type'=> "",
                'discount_value'=> $this->input->post('value'),
                'cart_value'=> $this->input->post('cart_value'),
                'uses_restriction'=> $this->input->post('restriction')
                 );
                 print_r($data);
                 if($this->product_model->editCoupon($id,$data)){
                    $this->session->set_flashdata('addmessage','Coupon edited Successfully.');
                    redirect("admin/coupons");
                }
            }
        }
        else
        {
            redirect('admin');
        }
    }

    function deleteCoupon($id)
    {
        if(_is_user_login($this)){
            $this->load->model('product_model');
            if($this->product_model->deleteCoupon($id))
            {
                $this->session->set_flashdata('addmessage','One Coupon deleted Successfully.');
                redirect("admin/coupons");
            }
        }
        else
        {
            redirect('admin');
        }
    }

    function dealofday()
    {

        $this->load->model("product_model");
        $data["deal_products"]  = $this->product_model->getdealproducts(); 

        $this->load->view('admin/deal/deal_list2',$data);
    }

    function add_dealproduct(){
        $this->load->helper('form');

        if(_is_user_login($this)){
       
          

            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    $this->load->model("product_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time")
                    
                    );
                    
                    
                    $this->product_model->adddealproduct($array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            
            $this->load->view("admin/deal/add2");
        }
        else
        {
            redirect('admin');
        }
    
    }
    
    function edit_deal_product($id){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("product_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time")
                    
                    );
                    
                   $this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->getdealproduct($id);
            $this->load->view("admin/deal/edit2",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    function delete_deal_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from deal_product where id = '".$id."'");
            redirect("admin/dealofday");
        }
        else
        {
            redirect('admin');
        }
    }

    public function feature_banner()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->feature_banner();
           $this->load->view('admin/feature_banner/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function add_feature_Banner()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("feature_slider",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/feature_banner');
                }
            }
        $this->load->view('admin/feature_banner/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
        
    public function edit_feature_banner($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_feature_banner($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_feature_banner($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/feature_banner');
                }
            }
           $this->load->view('admin/feature_banner/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function delete_feature_banner($id){
        if(_is_user_login($this)){
            $data = array();
            $this->db->query("Delete from feature_slider where id = '".$id."'");
            unlink("uploads/sliders/".$slider->slider_image);
            redirect("admin/feature_banner");
        }
        else
        {
            redirect('admin');
        }   
    }
        
    public function help()
    {
        if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('mobile', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('email', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->add_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/addcategories');
                }
            }
            $this->load->view('admin/help/form');
        }
        else
        {
            redirect('admin');
        }
    }
        
    public function move(){
        $header = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Auth-Token : A878BFCAF5D52016244C671D94FCAF06DD0753CD5356987289EDC317144C82FFAECC66A99800DBAB'
        );
        
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, "http://384772.true-order.com/WebReporter/api/v1/items?limit=30249");
        curl_setopt($curl , CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($curl, CURLOPT_HTTPHEADER, $header);
        
        $projects = curl_exec($curl);
        $p =json_decode($projects, true);
        
        //echo $projects (?limit=30249);
        
        $data = json_decode($projects);
        /*foreach ($data as $key => $item){
            if ($key=='items'){
                
                    foreach ($key as $k => $itemName){
                        echo '<br><br>Value found at array name=> '.$k."=>" . $itemName;
                    }
            }
            echo '<br><br>Value found at array key=> '.$key."=>" . $item;
        }*/
        foreach($data->items as $items) {
           echo  "<br><br>NAME =>".$itemName = $items->itemName;
           echo  "<br>description =>".$description = $items->description;
           
           foreach($items->stock as $stock) {
               //$stock = $items->stock;
               echo "<br>MRP =>".$mrp = $stock->mrp;
               echo "<br>S.P =>".$salePrice = $stock->salePrice;
               echo "<br>TAX(%) =>".$taxPercentage = $stock->taxPercentage;
               echo "<br>MAIN_cat =>".$cat = $stock->Cat2;
               echo "<br>SUB_cat =>".$sub_cat = $stock->Cat1;
               echo "<br>UNIT_VALUE =>".$unit_value = $stock->packing;
               echo "<br>TITLE =>".$variantName = $stock->variantName;
           }
        }
    }
    
    public function payment(){
        if(_is_user_login($this)){
        $data["paypal"]=$this->db->query("SELECT status FROM `paypal` where id = 1");
        $data["razor"]=$this->db->query("SELECT status FROM `razorpay` where id = 1");
        $this->load->view("admin/payment/list",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function paypal_detail(){
        
        if(_is_user_login($this)){
               
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('client_id', 'Client ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $client_id = $this->input->post("client_id");
                    //$emp_fullname = $this->input->post("emp_fullname");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'client_id'=>$client_id,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $this->common_model->data_update("paypal",$array,array("id"=>1)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }
                

            $data["paypal"]=$this->db->query("SELECT * FROM `paypal` where id = 1");
            $this->load->view("admin/payment/edit_paypal",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }
    
    public function razorpay_detail(){
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('api_key', 'Client ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $api_key = $this->input->post("api_key");
                    //$emp_fullname = $this->input->post("emp_fullname");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'api_key'=>$api_key,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $this->common_model->data_update("razorpay",$array,array("id"=>1)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }
            

            $data["razor"]=$this->db->query("SELECT * FROM `razorpay` where id = 1");
            $this->load->view("admin/payment/edit_razorpay",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }

    public function ads(){
        if(_is_user_login($this))
        {
            $data["ads"]=$this->db->query("SELECT * FROM `ads`");
            
            $this->load->view("admin/ads/list",$data);
        }
         else
            {
                redirect('admin');
            }
    }

    public function edit_ads($id){
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ads_key', 'Client ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $ads_key = $this->input->post("ads_key");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'ads_key'=>$ads_key,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $this->common_model->data_update("ads",$array,array("id"=>$id)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/ads');
                }
            }
            

            $data["ads"]=$this->db->query("SELECT * FROM `ads` where id ='".$id."'");
            $this->load->view("admin/ads/edit_ads",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }
    
    public function user_action($user_id){
        if(_is_user_login($this)){
        
            if(isset($_POST['profile']))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    extract($_POST);
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $this->db->select('user_password'); // Change it to what column name you have for id
                      $this->db->from('registers');
                      $this->db->where('user_id',$user_id ); // 'Yes' or 'yes', depending on what you have in db
                      $query = $this->db->get();
                      $pass= $query->row();
                    
                    if($pass->user_password==$password) 
                    {
                        $password_new=$password;
                    }
                    else
                    {
                        $password_new=md5($password);
                    }
                    
                    $update=$this->db->query("UPDATE `registers` SET `user_phone`='".$phone."',`user_fullname`='".$name."',`user_email`='".$email."',`user_password`='".$password_new."',`socity_id`='".$society."',`house_no`='".$home."',status='".$status."' WHERE `user_id`='".$user_id."'");
                    if(!$update){
                        redirect('admin/registers');
                    }
                    
                   //$this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/registers');
                }
            }
            
            if(isset($_POST['amount']))
            {


                $this->load->library('form_validation');
                $this->form_validation->set_rules('wallet', 'Name', 'trim|required');
                $this->form_validation->set_rules('rewards', 'Email', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    extract($_POST);
                    
                    $update=$this->db->query("UPDATE `registers` SET `wallet`='".$wallet."',`rewards`='".$rewards."' WHERE `user_id`='".$user_id."'");
                    if(!$update){
                        //header('location:w3school.com');
                        echo '<script language="javascript"> alert(Somthing Went Wrong. Uodate Not Successfull. ) </script>';
                        exit;
                    }
                    
                   //$this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/registers');
                }
            }
            $this->load->model("product_model");
            $qry=$this->db->query("SELECT * FROM `registers` where user_id = '".$user_id."'");
            $data["user"] = $qry->result();
            $data["order"] = $this->product_model->get_sale_orders(" and sale.user_id = '".$user_id."' AND sale.status=4 ");
            $this->load->view("admin/registers/useraction",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function notification22(){
        if(_is_user_login($this)){
            $serverObject = new SendNotification(); 
            $jsonString = $serverObject->sendPushNotificationToFCMSever( $token, $message, $order_id );  
            $jsonObject = json_decode($jsonString);
            return $jsonObject;
        }
        else
        {
            redirect('admin');
        }
    
    }
    
    public function language_status()
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `language_setting` WHERE id=1");
            $data["status"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["update"]))
            {
                extract($_POST);
                if($status=="")
                {
                    $status="0";
                }

                $this->load->library('form_validation');
                $update=$this->db->query("UPDATE `language_setting` SET `status`='".$status."' WHERE `id`=1 ");
                

                if (!$update)
                {
                   
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Update Not Successfull. Something wents Wrong</div>';
                   
                }
                else
                {
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Update Successfull </div>');
                    redirect('admin/language_status');
                }
            }
           $this->load->view('admin/setting/language',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function mobile_number()
    {
        $q = $this->db->query("select * from `tbl_numbers` WHERE id=1");
        $data["numbers"] = $q->row();
        
        if(isset($_REQUEST["update"]))
        {
            extract($_POST);

            $update=$this->db->query("UPDATE `tbl_numbers` SET `whatsapp`='".$whatsapp."',`calling`='".$call."' WHERE `id`=1");
            

            if (!$update)
            {
                $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Update Not Successfull. Something wents Wrong</div>';
                
            }
            else
            {
                $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Update Successfull </div>');
                redirect('admin/mobile_number');
            }
        }
        $q = $this->db->query("select * from `tbl_numbers` WHERE id=1");
        $data["numbers"] = $q->row();
        $this->load->view('admin/number_update',$data);
            
    }
     
   
   public function contact()
    {
     $data['fetch_contact']= $this->Web_model->fetch_contact();
	$this->load->view('admin/contact',$data);  
    }  
   
}
