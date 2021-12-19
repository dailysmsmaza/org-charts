<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requestfeedback extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("requestfeedback_model");
        $this->load->helper("form");
        $this->load->library('form_validation');
        $this->load->helper("inflector");
        $this->load->helper("text");
        $this->load->helper("url");     
        $this->load->library('pagination');        
        if ($this->session->userdata('id')=="") {
            redirect("login");
        }  
    }

    /**
     * Request Feedback
     */

     public function index() {
        $user_id=$this->session->userdata("id");
        $role =  $this->session->userdata('role');
        $data["page_title"] = "ORG Chart | Request Feedback";
        $data["heading_title"] = "Request Feedback";
        $this->load->view("admin/include/header",$data);
        $page_num = "";
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $srch_reqfddate = isset($_GET["srch_reqfddate"]) ? $_GET["srch_reqfddate"] : "";
        
        //print_r($user_id);exit;
        $condition=' where reqfd.reqfd_userfrom=umfrom.id and reqfd.reqfd_userto=umto.id';
        if($role==2){
            $condition.= " and reqfd_userfrom=".$user_id."";
         }
         if($role==3){
            $condition.= " and reqfd_userto=".$user_id.""; 
         }
         if($srch_reqfddate!=''){
          	$condition.= " and (CAST(reqfd_createddate as date) = '".$srch_reqfddate."')"; 
         }
         if($search!=''){
          	$condition.= " and (umfrom.first_name like '%$search%' or umto.first_name like '%$search%' or reqfd_subject Like '%$search%' or reqfd_message Like '%$search%' or reqfd_reply Like '%$search%')"; 
         }
         $config['total_rows'] = get_totalnumber_of_requestfeedback("requestfdbck_master",$condition);
         $config['page_query_string'] = TRUE;
         $config['enable_query_strings'] = TRUE;
         $data["total_requestfeedback"] = get_totalnumber_of_requestfeedback("requestfdbck_master",$condition);
 
         $config['per_page'] = 20;
         $config['use_page_numbers'] = TRUE;
         $data["feedbacks"] = $this->requestfeedback_model->get_requestfeedback_list($srch_reqfddate,$search,$config["per_page"],$page_num);
         $this->pagination->initialize($config);
         $this->load->view('admin/feedback/requestfeedback_list.php', $data);
         $this->load->view("admin/include/footer");
    }

    public function send_requestfeedbacks() {

    $this->form_validation->set_rules('reqfd_subject', 'Subject', 'required');   
    $this->form_validation->set_rules('reqfd_message', 'Message', '');
    $this->form_validation->set_rules('employee_id', 'Employee', '');
    $companyid = $this->session->userdata('id');
        
        if($companyid!=''){
          $companyids = get_userinfo($companyid, 'company', 'id');
          $company_id=$companyids['company'];
    }
    
    $user_id=$this->session->userdata("id");
    //$user_email=$this->session->userdata("email");
    //echo $user_email;exit;
    $data['requestfeedback'] = '';
    if ($this->form_validation->run() == FALSE) {
       $data["page_title"] = "ORG Chart | Send Request Feedback";
       $data["heading_title"] = "Send Request Feedback";
       $this->load->view("admin/include/header",$data);
       $data["company"] = $this->requestfeedback_model->get_company_list();
       $this->load->view('admin/feedback/send_requestfeedback', $data);
       $this->load->view("admin/include/footer");
    } else {
        $reqfd_subject = $this->input->post("reqfd_subject");
        $reqfd_message = $this->input->post("reqfd_message");
        $employee_id= $this->input->post("employee_id");

        $data = array(
            'reqfd_userfrom'=>$user_id,
            'reqfd_subject' => $reqfd_subject,
            "reqfd_message" => $reqfd_message,
            'company_id' => $company_id,
            'reqfd_userto'=>$employee_id,
            'reqfd_status'=>1,
            'reqfd_createddate' => current_datetime(),
            'reqfd_createdby' =>$user_id
        );
   
        $result = $this->requestfeedback_model->insert($data);
        //echo $data['reqfd_userto']; exit;
        if ($result) {
          // get user fields for rerfdfromdata  
           if($user_id!=''){
                $reqfdfromemail = get_userinfo($user_id, 'email', 'id');
                $reqfdfromfirst_name = get_userinfo($user_id, 'first_name', 'id');
                $reqfdfromlast_name = get_userinfo($user_id, 'last_name', 'id');
           } 

            // get user fields for rerfdtodata
           if($employee_id!=""){
                $reqfdtoemail = get_userinfo($employee_id, 'email', 'id');
                $reqfdtofirst_name = get_userinfo($employee_id, 'first_name', 'id');
                $reqfdtolast_name = get_userinfo($employee_id, 'last_name', 'id');
            }

               $from    = get_themeoption("email");                                            
               $to      = $reqfdtoemail['email'];                
               
               $subject = $data['reqfd_subject'];
               
               if($subject==''){ $subject='Request Feedback - Orgchart';}

               $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
               
               $emailbody="<body><table cellspacing='0' cellpadding='0' align='center' style='width:600px;background-color:#8080800f;margin:0 auto; border:1px solid #eaedf3;'>";
               $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Request Feedback - Orgchart</h4></td><td style='display:inherit;font-weight:200;height:325px;'>";
               
                $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                // here start email body
                $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$reqfdtofirst_name['first_name']." ".$reqfdtolast_name['last_name']."</td></tr>";
                
                $emailbody.="<tr><td>&nbsp;</td></tr>";

                $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$reqfdfromfirst_name['first_name']." ".$reqfdfromlast_name['last_name']." Sent your request for give feedback. Please check below Message.</td></tr>";
                $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$data['reqfd_message']."</td></tr>";
                $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'><b>Please <a href='".base_url('login')."' style='text-decoration:none;'>login</a> and give your feedback</b></td></tr>";

                $emailbody.="<tr><td>&nbsp;</td></tr>";
                $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></tr>";
                // Here end email body

                $emailbody.="</table>";

                $emailbody.="</td></tr>";
                $emailbody.="</table></body></html>";

                $message = $header.$emailbody;
                // echo $message;
                //  exit;
                send_mail($from,$to,$subject,$message);  
                $dpid = $this->db->insert_id();
                $this->session->set_flashdata("success", "Request Feedback Send Successfully...");
                redirect("requestfeedback");
                } else {
                    $this->session->set_flashdata("fail", "Request Feedback Not Send...");
                    redirect("requestfeedback/send_requestfeedback");
                }
     }

    }

    /*
     * Edit Company
     */

    public function edit($reqfd_id) {

        $data["page_title"] = "ORG Chart | Request Feedback";
        $data["heading_title"] = "Request Feedback";

        $reqfdtoemail = $reqfdtofirst_name = '';

        $role =  $this->session->userdata('role');
        $user_id= $this->session->userdata('id');
        if($user_id!=''){
            $reqfdfromemail = get_userinfo($user_id, 'email', 'id');
            $reqfdfromfirst_name = get_userinfo($user_id, 'first_name', 'id');
            $reqfdfromlast_name = get_userinfo($user_id, 'last_name', 'id');
        } 
        $requestdata = $this->db->query("SELECT * FROM requestfdbck_master WHERE reqfd_id = ".$reqfd_id);
        $reqfdrow = $requestdata->row();

        $reqfd_userfromID = $reqfdrow->reqfd_userfrom; 
        $reqfd_usersubject = $reqfdrow->reqfd_subject;
        $reqfd_usermessage = $reqfdrow->reqfd_message;
        $reqfd_usercreatedby = $reqfdrow->reqfd_createdby;
        $reqfd_usertoid = $reqfdrow->reqfd_userto;

        if($reqfd_userfromID!=""){
            $reqfdtoemail = get_userinfo($reqfd_userfromID, 'email', 'id');
            $reqfdtofirst_name = get_userinfo($reqfd_userfromID, 'first_name', 'id');
            $reqfdtolast_name = get_userinfo($reqfd_userfromID, 'last_name', 'id');
        }                

        $error=0;
        if($role==1 || $reqfd_usercreatedby==$user_id){
            $this->form_validation->set_rules('reqfd_subject',"Subject",'required' );
            $this->form_validation->set_rules('reqfd_message',"Message",'' );
            if($role==1){
                $this->form_validation->set_rules('reqfd_reply',"Reply",'required' );
            }
        }else{
            $this->form_validation->set_rules('reqfd_reply',"Reply",'required' );
        }

        if ($this->form_validation->run() == FALSE) {
            
        } else {
                $reqfd_subject= $this->input->post("reqfd_subject");
                $reqfd_message= $this->input->post("reqfd_message");
                $reqfd_reply= $this->input->post("reqfd_reply");

                $txtmessage = ($reqfd_usercreatedby==$user_id || $role==1)?$reqfd_message:$reqfd_reply;

             if($error == 0){
                if($reqfd_usercreatedby==$user_id || $role==1){
                    //'reqfd_status'=>1,
                    $data = array( 'reqfd_subject' => $reqfd_subject,'reqfd_message' => $reqfd_message, 'reqfd_updateddate' => current_datetime(),'reqfd_updatedby' =>$user_id);
                    if($reqfd_reply){ $data['reqfd_reply'] = $reqfd_reply; }
                    if($role==1){
                      $data = array(
                        'reqfd_subject' => $reqfd_subject,'reqfd_message' => $reqfd_message,'reqfd_status'=>0,'reqfd_updateddate' => current_datetime(),'reqfd_updatedby' =>$user_id);
                      if($reqfd_reply){ $data['reqfd_reply'] = $reqfd_reply; }
                    }
                
                }else{
                    $data = array('reqfd_reply' => $reqfd_reply,'reqfd_status'=>0,'reqfd_updateddate' => current_datetime(),'reqfd_updatedby' =>$user_id);
                }

                $result = $this->requestfeedback_model->update($data,$reqfd_id);

                if ($result) {
                   
                   if($role!=1){

                   if($role==3 && $reqfd_usercreatedby!=$user_id ){ 
                        $from    = get_themeoption("email");   

                        if($user_id == $reqfd_userfromID){
                            $to      = get_userinfo($reqfd_usertoid, 'email', 'id'); 
                        }else { 
                            $to      = $reqfdtoemail['email'];
                        }
                       $subject = $reqfd_usersubject;
               
                       if($subject==''){ $subject='Request Feedback - Orgchart';}
                       
                       $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                       
                       $emailbody="<body><table cellspacing='0' cellpadding='0' align='center' style='width:600px;background-color:#8080800f;margin:0 auto; border:1px solid #eaedf3;'>";
                       $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Request Feedback - Orgchart</h4></td><td style='display:inherit;font-weight:200;height:325px;'>";
                       
                        $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                        // here start email body
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$reqfdtofirst_name['first_name']." ".$reqfdtolast_name['last_name']."</td></tr>";
                        
                        $emailbody.="<tr><td>&nbsp;</td></tr>";

                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$reqfdfromfirst_name['first_name']." ".$reqfdfromlast_name['last_name']." Sent your Feedback. Please check below Message.</td></tr>";
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$txtmessage."</td></tr>";
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'><b>Please <a href='".base_url('login')."' style='text-decoration:none;'>login</a> check feedback</b></td></tr>";

                        $emailbody.="<tr><td>&nbsp;</td></tr>";
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></tr>";
                        // Here end email body

                        $emailbody.="</table>";

                        $emailbody.="</td></tr>";
                        $emailbody.="</table></body></html>";

                        $message = $header.$emailbody;
                        
                        // echo $message;
                        // exit;
                        send_mail($from,$to,$subject,$message);  
                    }else{
                      $from    = get_themeoption("email");                                            
                       //$to      = $reqfdtoemail['email'];
                        if($user_id == $reqfd_userfromID){
                            $to      = get_userinfo($reqfd_usertoid, 'email', 'id'); 
                        }else { 
                            $to      = $reqfdtoemail['email'];
                        }
                       
                       $subject = $reqfd_usersubject;
               
                       if($subject==''){ $subject='Request Feedback - Orgchart';}
                       
                       $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                       
                       $emailbody="<body><table cellspacing='0' cellpadding='0' align='center' style='width:600px;background-color:#8080800f;margin:0 auto; border:1px solid #eaedf3;'>";
                       $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Request Feedback - Orgchart</h4></td><td style='display:inherit;font-weight:200;height:325px;'>";
                       
                        $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                        // here start email body
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$reqfdtofirst_name['first_name']." ".$reqfdtolast_name['last_name']."</td></tr>";
                        
                        $emailbody.="<tr><td>&nbsp;</td></tr>";

                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$reqfdfromfirst_name['first_name']." ".$reqfdfromlast_name['last_name']." Sent your Feedback. Please check below Message.</td></tr>";
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$txtmessage."</td></tr>";
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'><b>Please <a href='".base_url('login')."' style='text-decoration:none;'>login</a> check feedback</b></td></tr>";

                        $emailbody.="<tr><td>&nbsp;</td></tr>";
                        $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></tr>";
                        // Here end email body

                        $emailbody.="</table>";

                        $emailbody.="</td></tr>";
                        $emailbody.="</table></body></html>";

                        $message = $header.$emailbody;
                        
                        // echo $message;
                        // exit;
                        send_mail($from,$to,$subject,$message);
                    }
                  }

                    $this->session->set_flashdata("success", "Request Feedback Update Successfully");
                    redirect("requestfeedback");

                } else {
                    $this->session->set_flashdata("fail", "Request Feedback Not  Update Successfully");
                    redirect("requestfeedback/edit".$id);
                }
            }
        }
        $this->load->view('admin/include/header',$data);
        $data["edit_requestfeedback"] =$this->requestfeedback_model->edit($reqfd_id);
        $this->load->view('admin/feedback/edit_requestfeedback', $data);
        $this->load->view('admin/include/footer');
    }

    public function delete($reqfd_id) {
        $result = $this->requestfeedback_model->delete($reqfd_id);
        if ($result) {
            $this->session->set_flashdata("success", "Request Feedback Delete Successfully");
            redirect("requestfeedback");
        } else {
            $this->session->set_flashdata("fail", "Request Feedback Not Delete Successfully");
            redirect("requestfeedback");
        }
    }

     /*
     * Change Status
     */

    public function changestatus($status, $reqfd_id) {
        $data = array('reqfd_status' => $status);
        $result = $this->requestfeedback_model->changestatus($data, $reqfd_id);
        if ($result) {
            $this->session->set_flashdata("success", "Request Feedback Status Update Successfully");
            redirect("requestfeedback");
        } else {
            $this->session->set_flashdata("fail", "Request Feedback Status Not  Update Successfully");
            redirect("requestfeedback");
        }
    }


  
}
