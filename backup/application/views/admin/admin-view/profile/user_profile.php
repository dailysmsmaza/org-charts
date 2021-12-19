<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
  <div class="clshiddenconsec">
   <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              	<div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>
                  <div class="action-td"><a class="actionicon editicon"  href="<?php echo base_url('login/edit_profile/'.$user_profile["id"]) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>
              	</div>
              	<?php if ($this->session->flashdata("success")) { ?>
				    <div class="alert alert-success">
				        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				        <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success"); ?>
				    </div>
				<?php } ?>	
              	<div class="whitebox">              		 
                  <div class=""></div>
                    <table  class="mobiletable userslist-table">            
                    		<tr>	                            
	                            <td colspan="2" align="center">
	                            	<img src="<?php echo ($user_profile["user_image"]!="") ? base_url('assets/userimage/'.$user_profile["user_image"]) : base_url('assets/images/user_demo.png')?>" class="rounded" style="height:100px;"></td>
	                        </tr>
	                        <tr>
	                            <th>Role</th>
	                            <td><?php echo get_userrole_name($user_profile["id"]) ?></td>
	                        </tr>
	                        <tr>
	                        	<th>First Name</th>
	                        	<td><?php echo $user_profile["first_name"] ?></td>
	                        </tr>
							<tr>
								<th>Last Name</th>
								<td><?php echo $user_profile["last_name"] ?></td>
							</tr>	                            
							<tr>
								<th>Email</th>
								<td><?php echo $user_profile["email"] ?></td>
							</tr>
	                        <tr>
	                        	<th>Phone</th>
	                        	<td><?php echo $user_profile["phone"] ?></td>
	                        </tr>
	                        <?php 
	                        	if($this->session->userdata("role")==3){
	                        ?>
	                        <tr>
	                        	<th>Designation</th>
	                        	<td><?php echo $user_profile["designation"] ?></td>
	                        </tr>
	                    <?php } ?>
	                    	<?php 
	                        	if($this->session->userdata("role")==3){
	                        ?>
	                        <tr>
	                        	<th>Skill</th>
	                        	<td><?php echo $user_profile["skill"] ?></td>
	                        </tr>
	                   	 <?php } ?>
	                        <tr>
	                        	<th>About</th>
	                        	<td><?php echo $user_profile["about"] ?></td>
	                        </tr>	                        
                    </table>                
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
        breakpoint: 768
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