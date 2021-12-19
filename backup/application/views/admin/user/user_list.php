<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
	<div class="clshiddenconsec">
		<div class="maincontainer">
       <div class="pageconent">
        <div class="pageconentbx">
              	<div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>             
                  <div class="addbtn adduser"><a href="<?php echo base_url('user/add_user') ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Add User</a></div>
              	</div>
              	<?php if ($this->session->flashdata("success")) { ?>
				    <div class="alert alert-success">
				        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				        	<?php echo $this->session->flashdata("success"); ?>
				    </div>
				<?php } ?>	
              	<div class="whitebox">
              		<div class="tablesearch">   

	                    <form method="GET" action="<?php echo base_url('user/index/') ?>" class="tablesearchform">                        	
	                        <input type="text" name="search" placeholder="Search" required="" class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : '' ; ?>">                           
	                        <input  type="submit"  value="Search" class="inpbtn">
	                        <a href="<?php echo base_url('user') ?>" class="inpbtn">Reset</a>  
	                    </form>                                    
                	</div>     
                  <div class=""></div>
                    <table  class="mobiletable userslist-table">            
                    	<thead>
	                        <tr>
	                            <th>Role</th>
	                            <th>First Name</th>
	                            <th>Last Name</th>
	                            <th>Email</th>
	                            <th>Phone</th>
	                            <th>Status</th>
	                            <th>Action</th>	
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <?php
	                        if (!empty($user_list)) {
	                            foreach ($user_list as $user_value) {
	                                ?>
	                                <tr>
	                                    <td><?php echo get_userrole_name($user_value["id"]) ?></td>
	                                    <td><?php echo $user_value["first_name"] ?></td>
	                                    <td><?php echo $user_value["last_name"] ?></td>
	                                    <td><?php echo $user_value["email"] ?></td>
	                                    <td><?php echo $user_value["phone"] ?></td>
	                                    <td class="<?php echo ($user_value["status"] == 1) ? 'activestatus' : 'deactivestatus' ?>"><?php echo ($user_value["status"] == 1) ? "Active" : "Deactive" ?></td>
	                                    <td class="action-td">
	                                        <?php
	                                        $status = "";
	                                        ($user_value["status"] == 1) ? $status = 0 : $status = 1;
	                                        ?>                            
	                                        <a class="actionicon activeicon" href="<?php echo base_url('user/changestatus/' . $status . '/' . $user_value['id']) ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
	                                        <a class="actionicon editicon"  href="<?php echo base_url('user/edit/' . $user_value['id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
	                                        <?php 
	                                        	if($user_value["id"] !=1){
	                                         ?>
	                                        <a class="actionicon deleteicon show-alert" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('user/delete/' . $user_value['id']) ?>"><i class="fa fa-trash" aria-hidden="true" ></i></a>
	                                    <?php }else{
	                                    	//echo "-";
	                                    } ?>
	                                    </td>
	                                </tr>
	                            <?php
	                            	}
	                        	} else {
	                            ?>
	                            	<tr><td colspan="7">Not Data Found</td></tr>
	                    	<?php } ?>
	                    	<tr><td colspan="7">Total Record (s) : <?php echo $total_user ?></td></tr>
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