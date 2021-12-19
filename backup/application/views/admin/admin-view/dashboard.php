<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
	<div class="clshiddenconsec">
		<div class="maincontainer">
	<div class="pageconent">
    	<div class="pageconentbx">
    		<?php if ($this->session->flashdata("success")) { ?>
				    <div class="alert alert-success">
				        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				        	<?php echo $this->session->flashdata("success"); ?>
				    </div>
			<?php } ?>	
          <div class="pageheding">
              <h2><?php echo $heading_title ?></h2>            
          </div>
          <div class="whitebox">
				<?php if($this->session->userdata("role") == 1) {?>			        		
	        	 	<div class="clsdashbord">
	        	 	<div class="row">
	        	 		<div class="col-lg-3 col-xs-6">
	          				<!-- small box -->
				          	<div class="small-box bg-aqua">
					           <div class="clssmallinnerboxcom clssmallinnerfrstbx">
					            <div class="inner">
					            	  <h2>Companies</h2>
						              <h3>Total <?php echo $total_record ?></h3>
						              
					            </div>
					            <div class="clsboximg">
					              <img src="<?php echo base_url('assets/images/company-icon.png');?>">
					            </div>
					            </div>
				            	<!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
				          	</div>
	        			</div>
	        			<div class="col-lg-3 col-xs-6">
	          				<!-- small box -->
				          	<div class="small-box bg-aqua">
				          		<div class="clssmallinnerboxcom clssmallinnerscndtbx">
					            <div class="inner"><?php
					            	$query = $this->db->query("SELECT * FROM employee_short GROUP BY company_id"); ?>
						              <h2>Created org chart</h2>
						              <h3>Total <?=$query->num_rows();?></h3>
					            </div>
					            <div class="clsboximg">
					              <img src="<?php echo base_url('assets/images/chart-icon.png');?>">
					            </div>
					           </div>
				            	<!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
				          	</div>
	        			</div>
	        	 	</div>
	        	 </div>
	        	<?php } ?>
	        	<?php 
	        		if ($this->session->userdata("role") == 2) {
	        	 ?>
	        	 <h4>Welcome <?php echo get_anycolunm("user_master","first_name",$this->session->userdata("id"))."  ".get_anycolunm("user_master","last_name",$this->session->userdata("id")) ?></h4>
	        	<?php } ?>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
<script type="text/javascript">
	 setTimeout(function () {
        $(".alert-danger").hide()
    }, 3000);
    setTimeout(function () {
        $(".alert-success").hide()
    }, 3000);
</script>