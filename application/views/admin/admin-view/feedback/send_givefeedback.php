<?php $role =  $this->session->userdata('role');
$companyid = $this->session->userdata("id");
$company   =  get_userinfo($companyid,"company","id");
$empcmpnm =$company['company'];
?>
<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
<div class="clshiddenconsec">
<div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $heading_title; ?></h2>              
                  
              </div>
               <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php
                    if ($this->session->flashdata("fail")) {
                ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata("fail") ?>
                    </div>
                <?php } ?>
                 
            <div class="whitebox">
                <div class=""></div>
                <div class="formwraper">
                    <form method="post" action=""  name="sendrequest_form" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Select Employee</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                            <select class="select2 form-control" id="employee_id" name="employee_id" >
                            <option value="">Select Employee</option>
                                <?php
                             
                                if($role==1){
                                   $query = $this->db->query("SELECT * FROM `user_master` where status=1 and role=3");
                                 }elseif($role==2){
                                  $query = $this->db->query("SELECT * FROM `user_master` where status=1 and role=3 and company=".$companyid);
                                 }else{
                                   $query = $this->db->query('SELECT * FROM `user_master` WHERE `status`=1 and role=3 and id!="'.$companyid.'" and company="'.$empcmpnm.'"  ' );
                                 }
                                 if($query->num_rows()){
                                    foreach ($query->result() as $user) {
                                      ?>
                                        <option value="<?=$user->id;?>"><?=$user->first_name.' '.$user->last_name;?></option>
                                        <?php
                                    }
                                }
                                ?>
                             </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Subject</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                 <input type="text" name="givefd_subject" id="givefd_subject" required="required" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Message</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="givefd_message" cols="35" rows="5" class="form-control"></textarea>
                                
                            </div>
                        </div>
                      
                         <div class="form-group row">
                            <input type="submit" value="Send">
                        </div>
                    </form>
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