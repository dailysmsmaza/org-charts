<?php
$role =  $this->session->userdata('role');?>
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
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo validation_errors(); ?>
                        </div>
                    <?php } ?>
                    <?php
                        if ($this->session->flashdata("fail")) {
                            ?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("fail") ?>
                            </div>
                    <?php } ?>
            <div class="whitebox">
                <div class="formwraper">
                    <form method="post" action="<?php echo base_url('givefeedback/edit/'.$edit_givefeedback['givefd_id']) ?>"  name="user_form" >
                    <?php
                      $userid =  $edit_givefeedback["givefd_id"];
                      $givefd_userfrom= $edit_givefeedback["givefd_userfrom"];
                      $givefd_userto= $edit_givefeedback["givefd_userto"];
                      $username = ''; $num = 0;
                      if($userid){
                        $username = get_userinfo($userid, 'first_name', 'id');
                        $givefdfromfname = get_userinfo($givefd_userfrom, 'first_name', 'id');
                        $givefdtofname = get_userinfo($givefd_userto, 'first_name', 'id');
                          $query =  $this->db->query('SELECT * FROM givefdbck_master WHERE givefd_id = '.$userid);
                          $num = $query->num_rows();
                        // print_r($givefdtofname);
                      }
                      if($role==1){
                      ?>
                       <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">From</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                               <?php echo $givefdfromfname['first_name']; ?>
                            </div>
                     </div>
                     <?php } ?>
                      <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">To</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                               <?php echo $givefdtofname['first_name']; ?>
                            </div>
                     </div> 
                   
                     <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Subject</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="givefd_subject" id="givefd_subject" value="<?php echo (set_value('givefd_subject'))?set_value('givefd_subject'):$edit_givefeedback['givefd_subject'] ?>" class="form-control">
                           </div>
                     </div>
                     <div class="form-group row">
                          <label class="col-md-3 col-lg-3 col-xl-2">Message</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="givefd_message" cols="35" rows="5" class="form-control"><?php echo (set_value('givefd_message'))?set_value('givefd_message'):$edit_givefeedback['givefd_message'] ?></textarea> 
                           </div>
                     </div>   
                    <div class="form-group row">
                            <input type="submit"  value="Send">
                     </div>                              
                </form>
             </div>
            </div>    
        </div>
    </div>
  </div>
</div>
</div>
 