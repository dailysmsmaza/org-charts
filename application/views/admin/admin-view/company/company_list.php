<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
  <div class="clshiddenconsec">
   <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              	<div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>             
                  <div class="addbtn adduser"><a href="<?php echo base_url('company/add_company') ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Add Company</a></div>
              	</div>
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
              		<div class="tablesearch">   

	                    <form method="GET" action="<?php echo base_url('company/index/') ?>" class="tablesearchform">                        	
	                        <input type="text" name="search" placeholder="Search" required="" class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : '' ; ?>">                           
	                        <input  type="submit"  value="Search" class="inpbtn">
	                        <a href="<?php echo base_url('company') ?>" class="inpbtn">Reset</a>  
	                    </form>                                    
                	</div>     
                  <div class=""></div>
                    <table  class="mobiletable userslist-table">            
                    	<thead>
	                        <tr>	                            
	                            <th>First Name</th>
	                            <th>Last Name</th>
	                            <th>Email</th>
	                            <th>Phone</th>
	                            <th>Total Employee</th>
	                            <th>Status</th>
	                            <th>Action</th>	
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <?php
	                        if (!empty($company_list)) {
	                            foreach ($company_list as $company_value) {
	                                ?>
	                                <tr>	                                    
	                                    <td><?php echo $company_value["first_name"] ?></td>
	                                    <td><?php echo $company_value["last_name"] ?></td>
	                                    <td><?php echo $company_value["email"] ?></td>
	                                    <td><?php echo $company_value["phone"] ?></td>
	                                    <td><?php 
	                                    		$where = " where company=".$company_value["id"]." and role='3'";
	                                    		echo get_totalnumber_of_employee("user_master",$where);
	                                     ?></td>
	                                    <td class="<?php echo ($company_value["status"] == 1) ? 'activestatus' : 'deactivestatus' ?>"><?php echo ($company_value["status"] == 1) ? "Active" : "Deactive" ?></td>
	                                    <td class="action-td">
	                                        <?php

	                                        $userid =  $company_value["id"];
											$username = ''; $num = 0;
											if($userid){
												$username = get_userinfo($userid, 'user_name', 'id');
											    $username = ($username)?$username['user_name']:'';

											    $query =  $this->db->query('SELECT * FROM employee_short WHERE company_id = '.$userid);
											    $num = $query->num_rows();
											}


	                                        $status = "";
	                                        ($company_value["status"] == 1) ? $status = 0 : $status = 1;
	                                        if($username && $num){ ?>
	                                        	<a class="actionicon viewicon" target="_blank" href="<?php echo base_url($username) ?>" title="View ORG Chart"><i class="fa fa-pie-chart" aria-hidden="true"></i></a><?php
	                                        } ?>
	                                        <a class="actionicon viewicon" href="<?php echo base_url('company/department/'.$company_value['id']) ?>" title="View Team"><i class="fa fa-building-o" aria-hidden="true"></i></a>
	                                        <a class="actionicon viewicon" href="<?php echo base_url('company/view_employee/'.$company_value['id']) ?>" title="View Employee"><i class="fa fa-eye" aria-hidden="true"></i></a>

	                                        <a class="actionicon activeicon" href="<?php echo base_url('company/changestatus/' . $status . '/' . $company_value['id']) ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
	                                        <a class="actionicon editicon"  href="<?php echo base_url('company/edit/' . $company_value['id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
	                                        <a class="actionicon deleteicon show-alert" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('company/delete/' . $company_value['id']) ?>"><i class="fa fa-trash" aria-hidden="true" ></i></a>
	                                    </td>
	                                </tr>
	                            <?php
	                            	}
	                        	} else {
	                            ?>
	                            	<tr><td colspan="7">Not Data Found</td></tr>
	                    	<?php } ?>
	                    	<tr><td colspan="7">Total Record (s) : <?php echo $total_company ?></td></tr>
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
  });
</script>
<script type="text/javascript">
	 setTimeout(function () {
        $(".alert-danger").hide()
    }, 3000);
    setTimeout(function () {
        $(".alert-success").hide()
    }, 3000);
</script>