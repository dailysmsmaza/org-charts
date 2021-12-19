<link href="<?php echo base_url('assets/select2/select2.min.css') ?>" rel="stylesheet">
<?php
$role =  $this->session->userdata('role'); 
$access_level=$this->session->userdata('access_level');
if($role==2 && $access_level==2){
  $companyid = $this->session->userdata('id');
}elseif ($role==3 && $access_level==2) {
  $companyid = $this->session->userdata('company');
}else{
   $companyid = $this->session->userdata('id');
}

if (isset($_POST["import"])) {

    //echo "exit";exit;

    $fileName   =  $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        $i = 0; $import = 0; $notimp = 0; $eml = '';
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $first_name = "";
            if (isset($column[0])) {
                $first_name = escapeString($column[0]);
            }
            $last_name = "";
            if (isset($column[1])) {
                $last_name = escapeString($column[1]);
            }
            $email = "";
            if (isset($column[2])) {
                $email = escapeString($column[2]);
            }
            //jc
            $password = "";
            $password = rand(100000, 999999);          
           
            $phone = "";
            if (isset($column[4])) {
                $phone = escapeString($column[4]);
            }
            $designation = "";
            if (isset($column[5])) {
                $designation = escapeString($column[5]);
            }
            $skill = "";
            if (isset($column[6])) {
                $skill = escapeString($column[6]);
            }
            $about = "";
            if (isset($column[7])) {
                $about = escapeString($column[7]);
            }
            $city = "";
            if (isset($column[8])) {
                $city = escapeString($column[8]);
            }

            $querycnt = $this->db->query("SELECT id FROM user_master WHERE email = '".$email."'");

            $cnt = $querycnt->num_rows();


            
            if($cnt){
                $type = "fail";
                $eml .= $email."<br> ";
                $notimp++;
            }else{
                    if($role==2 && $access_level==2){
                      $company = $this->session->userdata('id');
                    }elseif ($role==3 && $access_level==2) {
                      $company = $this->session->userdata('company');
                    }else{
                      $company = $this->session->userdata('id');
                    } 
                 
                //echo $company;exit();
                $roleemp = 3;
                $data = array('role' => $roleemp, 'company' => $company, 'first_name' => $first_name, 'last_name' => $last_name,  'email' => $email, 'phone' => $phone, 'designation' => $designation, 'about' => $about, 'skill' => $skill, 'city' => $city ,'password' => md5($password));
            //    echo "dasda";exit;

                if($i!= 0){

                 //  echo "dad";exit; 
                    $result = $this->db->insert('user_master', $data);

                    $insertId = $this->db->insert_id();
                                 
                 if ($result) {                
                    $from    =  get_themeoption("email");                                            
                   // $to      = $this->input->post("email");  
                    $to = $email;              

                    $subject = "Account Successfully Created - Org Chart";
                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
               
                   $emailbody="<body><table cellspacing='0' cellpadding='0' align='center' style='width:600px;background-color:#8080800f;margin:0 auto; border:1px solid #eaedf3;'>";
                   $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Account Succefully Created -  Orgchart</h4></td><td style='display:inherit;font-weight:200;height:340px;'>";
                   
                    $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                    // here start email body
                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$first_name." ".$last_name."</td></tr>";
                    
                    $emailbody.="<tr><td>&nbsp;</td></tr>";

                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Your account has been created in Org Charts</td></tr>";
                    
                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Username : ".$email."</td></tr>";
                    $emailbody.="<tr><td style='display:block;font-size:15px; font-family:Arial;color:#000000;'>Password : ".$password."</td></tr>";

                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Please <a href='".base_url('login')."' style='text-decoration:none;'>login</a> and give your feedback</td></tr>";

                    $emailbody.="<tr><td>&nbsp;</td></tr>";
                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></tr>";
                    // Here end email body

                    $emailbody.="</table>";

                    $emailbody.="</td></tr>";
                        $emailbody.="</table></body></html>";

                    $message = $header.$emailbody;
                    // echo $email;
                    // echo $password;
                    // echo $message;
                    //  exit;
                    send_mail($from,$to,$subject,$message);         
              }
                   

                    if (! empty($insertId)) {
                        $type = "success";
                        $msg = "CSV Data Imported successfully.";
                        $import++;
                    } else {
                        $type = "fail";
                        $msg = "Problem in Importing CSV Data.";
                        $notimp++;
                    }
                }

               
            }
            $i++;

            //echo $i;

        }
       // echo $eml;exit;
        if($eml){
            $this->session->set_flashdata("fail", "Email(s) is already exitst. <br>".$eml);
        }else{
            $this->session->set_flashdata($type, $msg);
        }
       // exit;

        redirect("employee");
    }else{
        $this->session->set_flashdata("fail", 'Please select csv file for import.');
        redirect("employee");
    }
}


?>
<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
    <div class="clshiddenconsec">
        <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>
                  <div class="addbtn adduser"><a href="<?php echo base_url('employee/add_employee') ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Add Employee</a></div>&nbsp;&nbsp;
                  <div class="addbtn adduser"><a id="createchart" href="<?= ($total_employee > 1)?base_url('employee/create_orgchart'):'javascript:void(0);'; ?>">Create Org Chart</a></div>
              </div>
              <div id="response"> </div>
              <?php if ($this->session->flashdata("success")) { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success"); ?>
                    </div>
                <?php } ?>  
                <?php if ($this->session->flashdata("fail")) { ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("fail"); ?>
                    </div>
                <?php } ?>          
            <div class="whitebox">
             		<?php 
	                if($this->session->userdata("role") == 1){
	                ?> 
	                <div class="tablesearch">     
	                     <div class="formwraper">                          
	                        <form method="GET" action="<?php echo base_url('employee/index/') ?>" class="tablesearchform">                               
	                                <div class="form-group row">                                    
	                                    <div class="col-lg-4">
	                                        <select name="company" id="company" class="form-control">
	                                            <option value="">Select Company</option>
	                                            <?php
	                                                $emp_company = isset($_GET["company"]) ? $_GET["company"] : "" ;
	                                                 $selected = "";
	                                                foreach ($company as $company_list) {                         
	                                                     if($company_list['id'] == $emp_company){
	                                                         $selected = "selected='selected'";
	                                                     }else{
	                                                        $selected = "";
	                                                     }
	                                                ?>
	                                                <option value="<?php echo $company_list['id']; ?>" <?php echo $selected ?>><?php echo $company_list['first_name'] . " " . $company_list['last_name']; ?></option>
	                                            <?php } ?>
	                                        </select> 
	                                    </div>
	                                    <div class="col-lg-4">
	                                        <input type="text" name="search" placeholder="Search"  class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : '' ; ?>">                                     
	                                    </div>
	                                    <div class="col-lg-4">
	                                        <button type="submit" class="inpbtn">Search</button> 
	                                         <a href="<?php echo base_url('employee') ?>" class="inpbtn">Reset</a>
	                                    </div>
	                                    
	                                </div>                                                        
	                            </div>                     
	                        </form>                                    
	                     </div>
	                </div>        
	                <?php } ?>                  
                <?php 
                    if($access_level == 2){ 
                        //if($role==2){
                        ?>
                        <div class="datafilter">
                            <div class="depratmentfilter">
                                <select name="departmentfilter" id="departmentfilter" class="select2">
                                    <option value="">Filter by Team</option><?php
                                    $departmentid = isset($_GET["department"]) ? $_GET["department"] : "" ;
                                    $query = $this->db->query("SELECT * FROM department_master WHERE status = 1 AND company_id = ".$companyid." ORDER BY name ASC");
                                    if($query->num_rows()){
                                        foreach ($query->result() as $user) { ?>
                                            <option <?=($departmentid == $user->id)?'selected':'';?> value="<?=$user->id;?>"><?=$user->name;?></option><?php
                                        }
                                    } ?>
                                </select>
                            </div>
                            <form class="form-horizontal" action="" method="post"
                                name="frmCSVImport" id="frmCSVImport"
                                enctype="multipart/form-data">

                                <div class="input-row">
                                    <label class="control-label">Choose CSV File</label> <input type="file" name="file"
                                        id="file" accept=".csv">
                                    <button type="submit" id="submit" name="import"  class="btn-submit">Import</button>
                                    &nbsp; <a target="_blank" href="<?=base_url('assets/chart/import-template.csv'); ?>">Download Example</a>
                                    <br />
                                </div>
                            </form>
                        </div>
                    <?php  
                        } 
                     ?>
                <table class="mobiletable userslist-table">
                    <thead>                
                        <tr>
                            <th>CEO</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Team</th>
                            <th>Access</th>
                            <th>Phone</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Action</th>	
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($employee_list)) {
                            foreach ($employee_list as $employee_value) {
                                $departmentname = '-';
                                if($employee_value['department_id']){
                                  $dquery = $this->db->query("SELECT * FROM department_master WHERE id = ".$employee_value['department_id']);
                                  $drow = $dquery->row();
                                  $departmentname = ($drow)?$drow->name:'-';
                                }

                                $start_date = (trim($employee_value['start_date']) && $employee_value['start_date'] != '0000-00-00')?date('d M, Y', strtotime($employee_value['start_date'])):'-'; ?>
                                <tr>
                                    <td><input type="radio" <?=($employee_value["ceo"])?'checked':'';?> name="ceo" onclick="changeceo(<?=$employee_value["id"] ?>);" value="<?=$employee_value["id"] ?>"></td>
                                    <td><?php echo $employee_value["first_name"] ?></td>
                                    <td><?php echo $employee_value["last_name"] ?></td>
                                    <td><?php echo $employee_value["email"] ?></td>
                                    <td align="center"><?php echo $departmentname; ?></td>
                                    <td>
                                        <?php 
                                        if($employee_value['access_level']==0){
                                            echo "Basic";
                                        }elseif($employee_value['access_level']==1)
                                        {
                                            echo "Team lead";
                                        }elseif($employee_value['access_level']==2){
                                            echo "Administrator";
                                        }
                                         ?>
                                        
                                    </td>
                                    <td><?php echo $employee_value["phone"] ?></td>
                                    <td align="center"><?php echo $start_date ?></td>
                                    <td class="<?php echo ($employee_value["status"] == 1) ? 'activestatus' : 'deactivestatus' ?>"><?php echo ($employee_value["status"] == 1) ? "Active" : "Deactive" ?></td>
                                    <td class="action-td">
                                        <?php
                                        $status = "";
                                        ($employee_value["status"] == 1) ? $status = 0 : $status = 1;
                                        ?>                            
                                        <a class="actionicon activeicon" href="<?php echo base_url('employee/changestatus/' . $status . '/' . $employee_value['id']) ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        <a class="actionicon editicon" href="<?php echo base_url('employee/edit/' . $employee_value['id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a class="actionicon deleteicon" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('employee/delete/' . $employee_value['id']) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="10">Not Data Found</td></tr>
                        <?php } ?>
                        <tr><td colspan="10">Total Record (s) : <?php echo $total_employee; ?></td></tr>
                    </tbody>
                </table>
		        <div class="pagination" style="margin-left:550px;">
		  			<?php echo $this->pagination->create_links(); ?>
				</div>
    		</div>
		</div>
	</div>
</div>
</div>
</div>
<script src="<?php echo base_url('assets/') ?>js/jquery.basictable.min.js"></script>
<script>
  $(document).ready(function() {
      $('.mobiletable').basictable({
        breakpoint: 991
      });

      <?php if($total_employee <= 1){ ?>
      $('#createchart').click(function(){
        $('#response').html('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> Please add or import employee. </div>');
      });
      <?php } ?>

      $('#createchart').click(function(){
          if($("input:radio[name='ceo']").is(":checked")) {
          }else{
              $('#response').html('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> Please select CEO. </div>');
              return false;
          }
      });

      $('#departmentfilter').change(function(){
        var id = $(this).val();
        id = (id)?'?department='+id:'';
       
        window.location.href = '<?=base_url('employee');?>'+id;
      });
  });

    function changeceo(id){
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>/employee/save_ceo", 
            data: {id: id},
            dataType: "text",  
            cache:false,
            success: 
              function(data){
                $('#response').html('<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> Employee successfully make CEO. </div>');
              }
        });
    }
</script>
<script src="<?php echo base_url('assets/select2/select2.full.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();
    });
</script>