<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model("home_model");
        $this->load->model("employee_model");
        $this->load->library('form_validation');
	}
	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()	{
		$data["page_title"] = "Org Chart";
		$this->load->view("include/header",$data);
		$data["testimonial"] = $this->home_model->get_testimonial();
		$this->load->view('home',$data);
		$this->load->view('include/footer');
	}

	public function contact()	{
		$data["page_title"] = "Contact Us";

		$this->form_validation->set_rules("email", "Email", "required|valid_email");
		$this->form_validation->set_rules("name", "Name", "required");
		$this->form_validation->set_rules("phone", "Phone", "");
		$this->form_validation->set_rules("subject", "Subject", "");
		$this->form_validation->set_rules("message", "Message", "required");

		if ($this->form_validation->run()) {
			$email = $this->input->post("email");
			$name = $this->input->post("name");
			$phone = $this->input->post("phone");
			$csubject = $this->input->post("subject");
			$message = $this->input->post("message");

			$from    =  get_themeoption("email");                                            
            $to      = get_anycolunm_anycondition("user_master","email","id",1);

            $subject = "Contact us - Org Chart";
            $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
            $body   =  "<body>
                            <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                 <tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>New Contact Message</h4></td><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:355px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:355px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi,"."&nbsp; Admin</td></tr><tr>
                                    <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>New contact request from orgchart. See below user details.
                                    	<table cellspacing='0' style='margin-top: 20px;' cellpadding='0'>
                                    		<tr>
                                    			<td><b style='font-weight: bold;'>Name: </b>".$name."</td>
                                    		</tr>
                                    		<tr>
                                    			<td><b style='font-weight: bold;'>Email: </b>".$email."</td>
                                    		</tr>
                                    		<tr>
                                    			<td><b style='font-weight: bold;'>Phone: </b>".$phone."</td>
                                    		</tr>
                                    		<tr>	
                                    			<td><b style='font-weight: bold;'>Subject: </b>".$csubject."</td>
                                    		</tr>
                                    		<tr>	
                                    			<td><b style='font-weight: bold;'>Message: </b>".$message."</td>
                                    		</tr>
                                    	</table>
                                    </td>
                            </tr><tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";

            $message = $header.$body;

            send_mail($from,$to,$subject,$message);     

            $this->session->set_flashdata("success", "Your message successfully send.");
            redirect(base_url("contact"));
		}

		$this->load->view("include/header",$data);
		$this->load->view('contact',$data);
		$this->load->view('include/footer');
	}

	public function orgchart($company) {
		//print_r($company);exit;
        $data["page_title"] = ucfirst($company)." - ORG Chart";

        $username = $this->uri->segment(1);
        //echo $username;exit;
		if($company){
			$check = $this->db->query("SELECT id FROM user_master WHERE status = 1 AND user_name = '".$company."'");
			$row = $check->row();
			if($row){
				$userid =  $row->id;

				$chartck = $this->db->query("SELECT * FROM user_master WHERE ceo = 1 AND company = '".$userid."'");
				$ct = $chartck->row();
				$this->load->view('admin/employee/orgchart', $data);
		  	}else{
		  		redirect(base_url());
		  	}
		}else{
			redirect(base_url());
		}
    }

    
    public function department_orgchart($company, $department) {
        $data["page_title"] = ucfirst($company)."-".ucfirst($department)." - ORG Chart";

        $username = $this->uri->segment(1);

		if($company && $department){
			$check = $this->db->query("SELECT id FROM user_master WHERE status = 1 AND user_name = '".$company."'");
			$row = $check->row();

			$dcheck = $this->db->query("SELECT id FROM department_master WHERE status = 1 AND slug = '".$department."'");
			$drow = $dcheck->row();

			if($row && $drow){
				$userid =  $row->id;

				$this->load->view('admin/department/orgchart', $data);
		  	}else{
		  		redirect(base_url());
		  	}
		}else{
			redirect(base_url());
		}
        
    }

    public function sharepdf($userid,$sharepdfusrname){

    	if($userid!=''){
    		$company = get_userinfo($userid, 'user_name', 'id');
    	}
    	//echo base_url($company['user_name']);exit();
 	  	$user_id=$this->session->userdata("id");
	   	if($user_id!=''){
            $usrfirst_name = get_userinfo($user_id, 'first_name', 'id');
            $usrlast_name = get_userinfo($user_id, 'last_name', 'id');
                    
        } 
        //echo "/".$company["user_name"];exit;
        $this->form_validation->set_rules('sharepdf_email', 'Email', 'required');   
        $this->form_validation->set_rules('share_message', 'Message', '');
        
       // print_r(base_url($company['user_name']));exit;

        if ($this->form_validation->run() == FALSE) {
              $data["page_title"] = "ORG Chart | Share Chart";
              $data["heading_title"] = " Shart Chart";
              $this->load->view("admin/include/header",$data);
              $this->load->view('admin/employee/orgchart', $data);
              $this->load->view('admin/include/footer');
	        } else {
     	 	   
     	 	    $sharepdf_email = $this->input->post("sharepdf_email");
	            $sharepdf_message = $this->input->post("sharepdf_message");
		          
		          $data = array(
		              'sharepdf_email' => $sharepdf_email,
		               "sharepdf_message" => $sharepdf_message,
		          );
          
                 $from    = get_themeoption("email");                                            
                 $to      = $data['sharepdf_email'];                
                 
                 $subject='Share Chart Information - Orgchart';

                 $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                 
                  
                 $emailbody="<body><table cellspacing='0' cellpadding='0' align='center'  style='width:600px;background-color:#8080800f;margin:0 auto; border: 1px solid #eaedf3;' >";
                 $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Chart Information - Orgchart</h4></td><td style='display:inherit;font-weight:200;height:325px;'>";
                 
                  $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                  // here start email body
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$data['sharepdf_email']."</td></tr>";

                  
                  $emailbody.="<tr><td>&nbsp;</td></tr>";

                  if($user_id!=''){
                  	$emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$usrfirst_name['first_name']." ".$usrlast_name['last_name']." Share a Information of Chart. </td></tr>";
	              	}else{
	                   $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'> Orgchart Share a Information of Chart. </td></tr>";
	                  }	
	               
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'> Please <a href='".base_url($sharepdfusrname.'/downloadorgchart/')."' style='text-decoration:none;' target='_blank'>Click</a> here for download chart..</td></tr>";

                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$data['sharepdf_message']."</td></tr>";
                  $emailbody.="<tr><td>&nbsp;</td></tr>";
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></tr>";
                  // Here end email body

                  $emailbody.="</table>";

                  $emailbody.="</td></tr>";

                  $emailbody.="</table></body></html>";
                  
                  $message = $header.$emailbody;
                 
                  //echo $message;exit;

                  send_mail($from,$to,$subject,$message); 

            $this->session->set_flashdata("success", "Send Email Successfully...");
            redirect(base_url($company['user_name']));
	
         	// $this->session->set_flashdata("fail", "Not Send...");
          //redirect("/".$company["user_name"]);
       }

    }

     public function sharepdf_department($userid,$username,$departmen_id,$department){

    	if($userid!=''){
    		$company = get_userinfo($userid, 'user_name', 'id');
    	}
    	// echo base_url($company['user_name'].'/team/'.$department);exit();
 	  	$user_id=$this->session->userdata("id");
	   	if($user_id!=''){
            $usrfirst_name = get_userinfo($user_id, 'first_name', 'id');
            $usrlast_name = get_userinfo($user_id, 'last_name', 'id');
                    
        } 
        //echo "/".$company["user_name"];exit;
        $this->form_validation->set_rules('sharepdf_email', 'Email', 'required');   
        $this->form_validation->set_rules('share_message', 'Message', '');
        
       // print_r(base_url($company['user_name']));exit;

        if ($this->form_validation->run() == FALSE) {
              $data["page_title"] = "ORG Chart | Share Chart";
              $data["heading_title"] = " Shart Chart";
              $this->load->view("admin/include/header",$data);
              $this->load->view('admin/employee/orgchart', $data);
              $this->load->view('admin/include/footer');
	        }else{
     	 	   
     	 	    $sharepdf_email = $this->input->post("sharepdf_email");
	            $sharepdf_message = $this->input->post("sharepdf_message");
		          
		          $data = array(
		              'sharepdf_email' => $sharepdf_email,
		               "sharepdf_message" => $sharepdf_message,
		          );
          
                 $from    = get_themeoption("email");                                            
                 $to      = $data['sharepdf_email'];                
                 
                 $subject='Share Chart Information - Orgchart';

                 $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                 
                  
                 $emailbody="<body><table cellspacing='0' cellpadding='0' align='center' style='width:600px;background-color:#8080800f;margin:0 auto; border: 1px solid #eaedf3;''>";
                 $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Chart Information - Orgchart</h4></td><td style='display:inherit;font-weight:200;height:325px;'>";
                 
                  $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                  // here start email body
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$data['sharepdf_email']."</td></tr>";

                  
                  $emailbody.="<tr><td>&nbsp;</td></tr>";

                  if($user_id!=''){
                  	$emailbody.="<tr><td style='display:block;font-size:15px; font-family:Arial;color:#000000;'>".$usrfirst_name['first_name']." ".$usrlast_name['last_name']." Share a Information of Chart. </td></tr>";
	              	}else{
	                   $emailbody.="<tr><td style='display:block;font-size:15px; font-family:Arial;color:#000000;'> Orgchart Share a Information of Chart. </td></tr>";
	                  }	
	               
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'> Please <a href='".base_url($username.'/team/'.$department.'/downloadteamorgchart')."' style='text-decoration:none;' target='_blank'>Click</a> here for download chart..</td></tr>";

	              $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>".$data['sharepdf_message']."</td></tr>";
                  $emailbody.="<tr><td>&nbsp;</td></tr>";
                  $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></tr>";
                  // Here end email body

                  $emailbody.="</table>";

                  $emailbody.="</td></tr>";

                  $emailbody.="</table></body></html>";
                  
                 
                  $message = $header.$emailbody;
                 
                 
                 // echo $message;exit;

                 send_mail($from,$to,$subject,$message); 

            $this->session->set_flashdata("success", "Send Email Successfully...");
            redirect(base_url($company['user_name'].'/team/'.$department));
	
         	// $this->session->set_flashdata("fail", "Not Send...");
          //redirect("/".$company["user_name"]);
       }

    }

    public function download_orgchart($company) {
    //print_r($company);exit;
        $data["page_title"] = ucfirst($company)." - ORG Chart";

        $username = $this->uri->segment(1);
        //echo $username;exit;
    if($company){
      $check = $this->db->query("SELECT id FROM user_master WHERE status = 1 AND user_name = '".$company."'");
      $row = $check->row();
      if($row){
        $userid =  $row->id;

        $chartck = $this->db->query("SELECT * FROM user_master WHERE ceo = 1 AND company = '".$userid."'");
        $ct = $chartck->row();
        $this->load->view('admin/employee/orgchartdownload', $data);
        }else{
          redirect(base_url());
        }
    }else{
      redirect(base_url());
    }
    }

     public function downloaddept_orgchart($company, $department) {
        $data["page_title"] = ucfirst($company)."-".ucfirst($department)." - ORG Chart";

        $username = $this->uri->segment(1);

		if($company && $department){
			$check = $this->db->query("SELECT id FROM user_master WHERE status = 1 AND user_name = '".$company."'");
			$row = $check->row();

			$dcheck = $this->db->query("SELECT id FROM department_master WHERE status = 1 AND slug = '".$department."'");
			$drow = $dcheck->row();

			if($row && $drow){
				$userid =  $row->id;

				$this->load->view('admin/department/downloadteam_orgchart', $data);
		  	}else{
		  		redirect(base_url());
		  	}
		}else{
			redirect(base_url());
		}
        
    }

}
