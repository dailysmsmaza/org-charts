<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Givefeedback extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("givefeedback_model");
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
        $data["page_title"] = "ORG Chart | Give Feedback";
        $data["heading_title"] = "Give Feedback";
        $this->load->view("admin/include/header",$data);
        $page_num = "";
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $srch_givedate = isset($_GET["srch_givedate"]) ? $_GET["srch_givedate"] : "";
        
        $condition=' where givefd.givefd_userfrom=umfrom.id and givefd.givefd_userto=umto.id';
        if($role!=1){
             $condition.= " and (givefd_userfrom=".$user_id.") ";
        }
        if($srch_givedate!=''){
            $condition.= " and (CAST(givefd_createddate as date) = '".$srch_givedate."')"; 
        }
        if($search!=''){
            $condition.= " and (umfrom.first_name like '%$search%' or umto.first_name like '%$search%' or givefd_subject Like '%$search%' or givefd_message Like '%$search%')"; 
         }
         $config['total_rows'] = get_totalnumber_of_givefeedback("givefdbck_master",$condition);
         $config['page_query_string'] = TRUE;
         $config['enable_query_strings'] = TRUE;
         $data["total_givefdbck"] = get_totalnumber_of_givefeedback("givefdbck_master",$condition);

        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["givefdbck"] = $this->givefeedback_model->get_givefeedback_list($srch_givedate,$search,$config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view('admin/feedback/givefeedback_list.php', $data);
        $this->load->view("admin/include/footer");
    }
    

    public function give_feedback(){

        $this->form_validation->set_rules('givefd_subject', 'Subject', 'required');   
        $this->form_validation->set_rules('givefd_message', 'Message', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');
        //$company_id = $this->session->userdata('id');

        $companyid = $this->session->userdata('id');
        
        if($companyid!=''){
          $companyids = get_userinfo($companyid, 'company', 'id');
          $company_id=$companyids['company'];
        }
        
        $user_id=$this->session->userdata("id");

        $data['requestfeedback'] = '';
      if ($this->form_validation->run() == FALSE) {
              $data["page_title"] = "ORG Chart | Send Give Feedback";
              $data["heading_title"] = "Send Give Feedback";
              $this->load->view("admin/include/header",$data);
              $data["company"] = $this->givefeedback_model->get_company_list();
              $this->load->view('admin/feedback/send_givefeedback', $data);
              $this->load->view('admin/include/footer');

      } else {
          $givefd_subject = $this->input->post("givefd_subject");
          $givefd_message = $this->input->post("givefd_message");
          $employee_id= $this->input->post("employee_id");

          $data = array(
              'givefd_userfrom'=>$user_id,
              'givefd_subject' => $givefd_subject,
              "givefd_message" => $givefd_message,
              'company_id' => $company_id,
              'givefd_userto'=>$employee_id,
              'givefd_status'=>1,
              'givefd_createddate' => current_datetime(),
              //'givefd_createddateby' =>$user_id
          );
     
          $result = $this->givefeedback_model->insert($data);
         //echo $data['reqfd_userto']; exit;
         if ($result) {

             // get user fields for rerfdfromdata  
             if($user_id!=''){
                  $givefdfromemail = get_userinfo($user_id, 'email', 'id');
                  $givefdfromfirst_name = get_userinfo($user_id, 'first_name', 'id');
                  $givefdfromlast_name = get_userinfo($user_id, 'last_name', 'id');
             } 

              // get user fields for rerfdtodata
             if($employee_id!=""){
                  $givefdtoemail = get_userinfo($employee_id, 'email', 'id');
                  $givefdtofirst_name = get_userinfo($employee_id, 'first_name', 'id');
                  $givefdtolast_name = get_userinfo($employee_id, 'last_name', 'id');
              }

                 $from    = get_themeoption("email");                                            
                 $to      = $givefdtoemail['email'];                
                 
                 $subject = $data['givefd_subject'];
                 
                 if($subject==''){ $subject='Request Feedback - Orgchart';}

                 $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                 
                 $emailbody="<body><table cellspacing='0' cellpadding='0' align='center' style='width:600px;background-color:#8080800f;margin:0 auto; border:1px solid #eaedf3;'>";
                 $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Request Feedback - Orgchart</h4></td><td style='display:inherit;font-weight:200;height:325px;'>";
                 
                  $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                  // here start email body
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$givefdtofirst_name['first_name']." ".$givefdtolast_name['last_name']."</td></tr>";
                  
                  $emailbody.="<tr><td>&nbsp;</td></tr>";

                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$givefdfromfirst_name['first_name']." ".$givefdfromlast_name['last_name']." Sent your give feedback. Please check below Message.</td></tr>";
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$data['givefd_message']."</td></tr>";
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
            $this->session->set_flashdata("success", "Give Feedback Send Successfully...");
            redirect("givefeedback");
            } else {
             $this->session->set_flashdata("fail", "Give Feedback Not Send...");
             redirect("givefeedback/give_feedback");
            }
       }

    }


    public function edit($givefd_id) {

        $role =  $this->session->userdata('role');
        $user_id= $this->session->userdata('id');
        $data["page_title"] = "ORG Chart | Give Feedback";
        $data["heading_title"] = "Give Feedback";
        $error=0;
        
        $this->form_validation->set_rules('givefd_subject',"Subject",'required' );
        $this->form_validation->set_rules('givefd_message',"Message",'' );
        
        if ($this->form_validation->run() == FALSE) {
            
        } else {
                $givefd_subject= $this->input->post("givefd_subject");
                $givefd_message= $this->input->post("givefd_message");
                
             if($error == 0){
               
                $data = array(
                    'givefd_subject' => $givefd_subject,'givefd_message' => $givefd_message);
               
                $result = $this->givefeedback_model->update($data,$givefd_id);

                if ($result) {
                    $this->session->set_flashdata("success", "give Feedback Update Successfully");
                    redirect("givefeedback");

                } else {
                    $this->session->set_flashdata("fail", "Give Feedback Not  Update Successfully");
                      redirect("givefeedback/edit".$givefd_id);
                }
            }
        }
        $this->load->view('admin/include/header',$data);
        $data["edit_givefeedback"] =$this->givefeedback_model->edit($givefd_id);
        $this->load->view('admin/feedback/edit_givefeedback', $data);
        $this->load->view('admin/include/footer');
    }

        public function delete($givefd_id) {
        $result = $this->givefeedback_model->delete($givefd_id);
        if ($result) {
            $this->session->set_flashdata("success", "Give Feedback Delete Successfully");
            redirect("givefeedback");
        } else {
            $this->session->set_flashdata("fail", "Give Feedback Not Delete Successfully");
            redirect("givefeedback");
        }
    }

    public function receviedfeedback() {
        $user_id=$this->session->userdata("id");
        $role =  $this->session->userdata('role');
       // print_r($user_id);exit();
        $data["page_title"] = "ORG Chart | Received Feedback";
        $data["heading_title"] = "Received Feedback";
        $this->load->view("admin/include/header",$data);
        $page_num = "";
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $srch_givedate = isset($_GET["srch_givedate"]) ? $_GET["srch_givedate"] : "";
        
        $condition=' where givefd.givefd_userfrom=umfrom.id and givefd.givefd_userto=umto.id';
        if($role!=1){
               $condition.= " and (givefd_userto=".$user_id.") ";
        }
        if($srch_givedate!=''){
            $condition.= " and (CAST(givefd_createddate as date) = '".$srch_givedate."')"; 
        }
        if($search!=''){
            $condition.= " and (umfrom.first_name like '%$search%' or umto.first_name like '%$search%' or givefd_subject Like '%$search%' or givefd_message Like '%$search%')"; 
         }
         $config['total_rows'] = get_totalnumber_of_givefeedback("givefdbck_master",$condition);
         $config['page_query_string'] = TRUE;
         $config['enable_query_strings'] = TRUE;
         $data["total_givefdbck"] = get_totalnumber_of_givefeedback("givefdbck_master",$condition);

        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["givefdbck"] = $this->givefeedback_model->get_receviedgivefeedback_list($srch_givedate,$search,$config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view('admin/feedback/receivedgivefeedback_list.php', $data);
        $this->load->view("admin/include/footer");
    }

    public function view($givefd_id) {

        $role =  $this->session->userdata('role');
        $user_id= $this->session->userdata('id');
        $data["page_title"] = "ORG Chart | Received Feedback";
        $data["heading_title"] = "Received Feedback";
        $error=0;
        
        $this->form_validation->set_rules('givefd_subject',"Subject",'required' );
        $this->form_validation->set_rules('givefd_message',"Message",'' );
        
        $this->load->view('admin/include/header',$data);
        $data["edit_givefeedback"] =$this->givefeedback_model->edit($givefd_id);
        $this->load->view('admin/feedback/view_givefeedback', $data);
        $this->load->view('admin/include/footer');
    }
      
    

}
