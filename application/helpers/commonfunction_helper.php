<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Get User Role*/
if ( ! function_exists('get_userrole')){
    function get_userrole($id){
        $CI = & get_instance();
        $sql    = "select role from user_master where id='$id'";
        $ex     = $CI->db->query($sql);
        $result = $ex->row_array();
        if(!empty($result)){
          $role= "";
            if($result["role"] == 1){
                $role = 1;
            }elseif ($result["role"] == 2) {
                $role = 2;
            }elseif ($result["role"] == 3) {
                $role = 3;
            }
            return $role;
        }else{
          return false;
        }
    }   
}

/* Get User Access Level*/
if ( ! function_exists('get_useraccess')){
    function get_useraccess($id){
        $CI = & get_instance();
        $sql    = "select access_level from user_master where id='$id'";
        $ex     = $CI->db->query($sql);
        $result = $ex->row_array();
        if(!empty($result)){
          $access_level= "";
            if($result["access_level"] == 0){
                $access_level = 0;
            }elseif ($result["access_level"] == 1) {
                $access_level = 1;
            }elseif ($result["access_level"] == 2) {
                $access_level = 2;
            }elseif ($result["access_level"] == 3) {
                $access_level = 3;
            }
            return $access_level;
        }else{
          return false;
        }
    }   
}


/* Get User Role Name*/
if ( ! function_exists('get_userrole_name')){
    function get_userrole_name($id){
        $CI = & get_instance();
        $sql    = "select role,ceo from user_master where id='$id'";
        $ex     = $CI->db->query($sql);
        $result = $ex->row_array();
        if(!empty($result)){
          $role= "";
            if($result["role"] == 1){
                $role = "Admin";
                return $role;
            }elseif ($result["role"] == 2) {
                $role = "Company";
                return $role;
            }elseif ($result["role"] == 3) {
               $role = "Employee";
               return $role;
            }
            
        }else{
          return false;
        }
    }   
}

/* Get Any Colunm in Any Table*/
if ( ! function_exists('get_anycolunm')){
    function get_anycolunm($table,$colunm,$id){
        $CI     = & get_instance();
        $sql    = "select $colunm from $table where id='$id'";        
        $ex     = $CI->db->query($sql);
        $result = $ex->row_array();
        if(!empty($result)){
          return $result[$colunm];
        }else{
          return false;
        }
    }   
}

/* Get Any Colunm in Any Table with any colunm Condition*/
if ( ! function_exists('get_anycolunm_anycondition')){
    function get_anycolunm_anycondition($table,$colunm,$where_colunm,$where_value){
        $CI     = & get_instance();
        $sql    = "select $colunm from $table where $where_colunm='$where_value'  ";        
        $ex     = $CI->db->query($sql);
        $result = $ex->row_array();
        if(!empty($result)){
          return $result[$colunm];
        }else{
          return false;
        }
    }   
}

/* Get Any Two Colunm in Any Table with any colunm Condition*/
if ( ! function_exists('get_anytwocolunm_anycondition')){
    function get_anytwocolunm_anycondition($table,$colunm,$colunm2,$where_colunm,$where_value){
        $CI     = & get_instance();
        $sql    = "select $colunm,$colunm2 from $table where $where_colunm='$where_value'";        
        $ex     = $CI->db->query($sql);
        $result = $ex->row_array();
        if(!empty($result)){
          return $result;
        }else{
          return false;
        }
    }   
}


/* Get User Filed*/
if ( ! function_exists('get_userinfo')){
    function get_userinfo($id,$colunm1="",$colunm2=""){
        $CI = & get_instance();
        $sql    = "select $colunm1,$colunm2 from user_master where id='$id'";
        $ex     = $CI->db->query($sql);
        $result = $ex->row_array();
        if(!empty($result)){
          return $result;
        }else{
          return false;
        }
    }   
}

/*Count Total Number Of Rows In Any Table*/
 if(!function_exists('get_totalnumber_of_rows')){
    function get_totalnumber_of_rows($table,$condition){
        $CI = & get_instance();        
        $sql    = "select id from $table $condition";
        $ex     = $CI->db->query($sql);
        // $CI->db->last_query();exit();
        $result = $ex->row_array();
        $no     = $ex->num_rows();        
        if($no > 0){
            return $no;
        }else{
            return 0;
        }
        
    }
 }

 /*Count Total Number Of Employee of Company*/
 if(!function_exists('get_totalnumber_of_employee')){
    function get_totalnumber_of_employee($table,$condition){
        $CI = & get_instance();        
        $sql    = "select count(id) as total_employee from $table $condition";
        $ex     = $CI->db->query($sql);
        //echo $CI->db->last_query();
        $result = $ex->row_array();        
        if(!empty($result)){
            return $result["total_employee"];
        }else{
            return 0;
        }        
    }
 }

  /*Count Total Number Of Employee of Company*/
 if(!function_exists('get_totalnumber_of_requestfeedback')){
    function get_totalnumber_of_requestfeedback($table,$condition){
        $CI = & get_instance();        
        $sql    = "select reqfd_id,company_id, umfrom.first_name as reqfd_userfrom,reqfd_subject,reqfd_message,umto.first_name as reqfd_userto,reqfd_status,reqfd_reply,reqfd_createddate,reqfd_createdby,reqfd_updateddate,reqfd_updatedby from $table as reqfd,user_master as umfrom, user_master as umto $condition";
        $ex     = $CI->db->query($sql);
        // $CI->db->last_query();exit();
        $result = $ex->row_array();
        $no     = $ex->num_rows();        
        if($no > 0){
            return $no;
        }else{
            return 0;
        }
    }
 }

  /*Count Total Number Of Employee of Company*/
 if(!function_exists('get_totalnumber_of_givefeedback')){
    function get_totalnumber_of_givefeedback($table,$condition){
        $CI = & get_instance();        
        $sql    = "select givefd_id,`company_id`, umfrom.first_name as givefd_userfrom,givefd_subject,givefd_message,umto.first_name as givefd_userto,givefd_status,givefd_createddate,givefd_updateddate from $table as givefd, user_master as umfrom, user_master as umto $condition";
        $ex     = $CI->db->query($sql);
        // $CI->db->last_query();exit();
        $result = $ex->row_array();
        $no     = $ex->num_rows();        
        if($no > 0){
            return $no;
        }else{
            return 0;
        }
    }
 }


/*Check Any Colunm IS Exist OR Not In Any Table*/
if ( ! function_exists('checkcolunm_exist')){
    function checkcolunm_exist($table,$colunm,$colunm_value){
        $CI = & get_instance();
        $sql  = "select $colunm from $table where $colunm='$colunm_value' and is_delete=0";
        $ex   = $CI->db->query($sql);
        $no   = $ex->num_rows();
        if($no){
          return true;
        }else{
          return false;
        }
    }   
}
/*Check User Name IS Exist OR Not*/
if ( ! function_exists('checkusername_exist')){
    function checkusername_exist($username){
        $CI = & get_instance();
        $sql  = "select user_name from user_master where user_name='$username' and is_delete=0";
        $ex   = $CI->db->query($sql);
        $no   = $ex->num_rows();
        if($no == 1){
          return true;
        }else{
          return false;
        }
    }   
}
/* Check Login User Company*/
if (! function_exists('get_company')) {
    function get_company($id){
        $CI = & get_instance();
        $sql     = "select company_id,company_name from company_master where company_id='$id'";
        $ex      = $CI->db->query($sql);
        $result  = $ex->row_array();
        if(!empty($result)){
            return $result;
        }
    }   
}
/*Set Character length Menu /navigation */
if (! function_exists('set_character_length')) {
    function set_character_length($x, $length){
      if(strlen($x)<=$length){
        echo $x;
      }
      else
      {
        $y = substr($x,0,$length) . '<br>';
        echo $y;
      }
    }
}   
/* Get Theme Option */
if (!function_exists('get_themeoption')) {

    function get_themeoption($key) {
        $ci = get_instance();
        $ci->load->database();
        $ci->db->select("*");
        $ci->db->from("setting");
        $ci->db->where("meta_key", $key);
        $query = $ci->db->get();
        $result = $query->row_array();
        return (isset($result["meta_value"])) ? $result["meta_value"] : '';
    }
}

/*Get Any Colunm name in Any table*/
if ( ! function_exists('get_table_info')){
    function get_table_info($table,$selectcolunm,$where_colunm="",$where_id=""){
        $CI = & get_instance();
        $condition = "";
        if($where_colunm!="" && $where_id!=""){
            $condition = " where $where_colunm='$where_id'";
        }
       $sql= "select $selectcolunm from $table $condition";
        $ex = $CI->db->query($sql);
        $shuttle = $ex->row_array();
        $result = !empty($shuttle[$selectcolunm]) ?  $shuttle[$selectcolunm] :  0;
        return $result;

    }   
}

/*Get Any Colunm name in Any table*/
if ( ! function_exists('get_table_info2')){
    function get_table_info2($table,$selectcolunm,$where_colunm="",$where_id=""){
        $CI = & get_instance();
        $condition = "";
        if($where_colunm!="" && $where_id!=""){
            $condition = " where $where_colunm='$where_id'";
        }
        $sql= "select $selectcolunm from $table $condition ";
        $ex = $CI->db->query($sql);
        $shuttle_company = $ex->row_array();
        $result = !empty($shuttle_company['company_id']) ?  $shuttle_company['company_id'] :  0;
        return $shuttle_company;
    }   
}


if(!function_exists('escapeString')){
    function escapeString($val) {
        $db = get_instance()->db->conn_id;
        $val = mysqli_real_escape_string($db, $val);
        return $val;
    }
}

if(!function_exists('category_tree')){ 
    //Recursive php function
    function category_tree($catid){
        $CI      = get_instance();
        $userid =  $CI->session->userdata('id');
        $query = $CI->db->query("SELECT um.id, um.first_name, um.last_name, um.designation FROM user_master as um 
                                            JOIN employee_short as es ON um.id = es.item_id 
                                           WHERE um.status = 1 AND is_delete = 0 AND um.ceo != 1 AND um.company = ".$userid." AND es.parent_id = ".$catid." 
                                        ORDER BY es.id ASC");
        echo '<ol class="sortable movesortble">';
        foreach ($query->result() as $res) {
            $i = 0;
            //if ($i == 0) echo '<ol class="sortable">'; ?>
            <li id="menuItem_<?=$res->id;?>" data-id="<?=$res->id;?>">
                <div class="menuDiv"><b><?=$res->first_name.' '.$res->last_name;?></b><br /><span><?=$res->designation;?></span></div><?php
                category_tree($res->id); ?>
            </li><?php
            $i++;
            //if ($i > 0) echo '</ol>';
        }
        echo '</ol>';
    }
}

if(!function_exists('orgchart_tree')){ 
    //Recursive php function
    function orgchart_tree($catid, $username = '', $department = ''){
        $CI      = get_instance();
        $username = ($username)?$username:$CI->uri->segment(1);
        if($username){
            $check = $CI->db->query("SELECT id FROM user_master WHERE user_name = '".$username."'");
            $row = $check->row(); $chart = array();
            if($row){
                $userid =  $row->id;
                $dcond = ''; $table = 'employee_short';
                if($department){ $dcond = ' AND um.department_id = '.$department.' '; $table = 'department_employee_short'; }
                /*echo "SELECT um.id, um.first_name, um.last_name, um.designation, es.item_id, um.user_image 
                                           FROM user_master as um 
                                           JOIN ".$table." as es ON um.id = es.item_id 
                                          WHERE um.status = 1 AND is_delete = 0 AND um.company = ".$userid.$dcond." AND es.parent_id = ".$catid." 
                                       ORDER BY es.id ASC";*/
                $query = $CI->db->query("SELECT um.id, um.first_name, um.last_name, um.designation, es.item_id, um.user_image 
                                           FROM user_master as um 
                                           JOIN ".$table." as es ON um.id = es.item_id 
                                          WHERE um.status = 1 AND is_delete = 0 AND um.company = ".$userid.$dcond." AND es.parent_id = ".$catid." 
                                       ORDER BY es.id ASC");
                //print_r($query->result()); exit();
                foreach ($query->result() as $res) {
                    $childcount = 0;
                    $orgchart = array();
                    $subquery = $CI->db->query("  SELECT um.id, um.first_name, um.last_name, um.designation, es.item_id 
                                                    FROM user_master as um 
                                                    JOIN ".$table." as es ON um.id = es.item_id 
                                                   WHERE um.status = 1 AND is_delete = 0 AND um.company = ".$userid.$dcond." AND es.parent_id = ".$res->item_id." 
                                                ORDER BY es.id ASC");

                    $image = ($res->user_image)?'assets/userimage/'.$res->user_image:'assets/images/user-profile.jpg';
                    $orgchart['id'] = $res->id;
                    $orgchart['name'] = $res->designation;
                    $orgchart['title'] = $res->first_name.' '.$res->last_name;
                    $orgchart['image'] = base_url($image);
                    $orgchart['relationship'] = array('children_num' => $subquery->num_rows());
                    if($subquery->num_rows())
                    $orgchart['children'] = orgchart_tree($res->id, $username, $department);

                    $chart[] = $orgchart; 
                }
            }
        }
        return $chart;
    }
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

/* Send Mail For New User Created */
if(!function_exists('send_mail')){
    function send_mail($from,$to,$subject,$message,$attachment=''){            
        $CI = get_instance();
        $CI->load->library('email');        
        $config = array();
        $config['mailtype']='html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;        
        $CI->email->initialize($config);

        $CI->email->from($from,get_themeoption('title'));// get site name in setting
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);
        // $pdfFilePath = FCPATH . "/assets/images/_Karimalik_.pdf"
        // $CI->email->attach($pdfFilePath);
        $CI->email->attach($attachment);
        //$CI->email->addAttachment('/assets/userimages/06062020_035057_user2.png');
       // $CI->email->AddEmbeddedImage('/assets/userimages/06062020_035057_user2.png');

        if($CI->email->send()) {
          //echo "success";
            return true;
        } else {
            return false;
        }
    }
}

if(!function_exists('get_deparment_members')){
    function get_deparment_members($id){
        $CI = get_instance();
        $query = $CI->db->query("SELECT * FROM user_master WHERE department_id = ".$id." AND status = 1 AND is_delete = 0");
        return $query->num_rows(); 
    }
}

    //-- current date time function
    if(!function_exists('current_datetime')){
        function current_datetime(){        
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date_time = $dt->format('Y-m-d H:i:s');      
            return $date_time;
        }
    }