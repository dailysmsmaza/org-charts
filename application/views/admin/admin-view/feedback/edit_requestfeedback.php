<?php
$user_id =  $this->session->userdata('id');
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
                    <form method="post" action="<?php echo base_url('requestfeedback/edit/'.$edit_requestfeedback['reqfd_id']) ?>"  name="user_form" >
                    <?php
                      $userid =  $edit_requestfeedback["reqfd_id"];
                      $reqfdfrom= $edit_requestfeedback["reqfd_userfrom"];
                      $reqfdto= $edit_requestfeedback["reqfd_userto"];
                      $reqfd_createdby= $edit_requestfeedback["reqfd_createdby"];
                      $reqfd_updatedby= $edit_requestfeedback["reqfd_updatedby"];
                      $username = ''; $num = 0;
                      if($userid){
                        $username = get_userinfo($userid, 'first_name', 'id');
                        $reqfdfromfname = get_userinfo($reqfdfrom, 'first_name', 'id');
                        $reqfdtofname = get_userinfo($reqfdto, 'first_name', 'id');
                          $query =  $this->db->query('SELECT * FROM requestfdbck_master WHERE reqfd_id = '.$userid);
                          $num = $query->num_rows();
                        // print_r($reqfdtofname);
                      }
                      
                     if($role!=2){ ?>
                     
                     <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">From</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                               <?php echo $reqfdfromfname['first_name']; ?>
                            </div>
                     </div>
                   <?php } ?>
                      <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">To</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                               <?php echo $reqfdtofname['first_name']; ?>
                            </div>
                     </div> 
                     <?php if($reqfd_createdby==$user_id || $role==1){ ?>
                      <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Subject</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="reqfd_subject" id="reqfd_subject" value="<?php echo (set_value('reqfd_subject'))?set_value('reqfd_subject'):$edit_requestfeedback['reqfd_subject'] ?>" class="form-control">
                           </div>
                     </div>
                     <div class="form-group row">
                          <label class="col-md-3 col-lg-3 col-xl-2">Message</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="reqfd_message" cols="35" rows="5" class="form-control"><?php echo (set_value('reqfd_message'))?set_value('reqfd_message'):$edit_requestfeedback['reqfd_message'] ?></textarea> 
                           </div>
                     </div>   
                      <?php } else { ?> 
                     <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Subject</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                               <?php echo $edit_requestfeedback['reqfd_subject']; ?>
                            </div>
                     </div>
                     <div class="form-group row">
                          <label class="col-md-3 col-lg-3 col-xl-2">Message</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <?php echo $edit_requestfeedback['reqfd_message']; ?>
                           </div>
                     </div> 
                     <?php }
                     if($role==2 || $reqfd_createdby==$user_id){
                      if($edit_requestfeedback['reqfd_reply']!=''){
                        ?>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Reply</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                              <?php echo $edit_requestfeedback['reqfd_reply']; ?>
                            </div>
                          </div>
                        <?php
                        }
                     }
                     if($role==1){
                      ?>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Reply</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                              <textarea name="reqfd_reply" cols="35" rows="5" class="form-control"><?php echo (set_value('reqfd_reply'))?set_value('reqfd_reply'):$edit_requestfeedback['reqfd_reply'] ?></textarea>
                            </div>
                          </div>
                        <?php
                     }

                     if(($reqfd_createdby!=$user_id) && $role!=2 && $role!=1){ 
                      //if($edit_requestfeedback['reqfd_reply']!=''){
                        ?>
                     <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Reply</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                              <textarea name="reqfd_reply" cols="35" rows="5" class="form-control"><?php echo (set_value('reqfd_reply'))?set_value('reqfd_reply'):$edit_requestfeedback['reqfd_reply'] ?></textarea>
                            </div>
                     </div>
                     <?php } //}
                     //if($edit_requestfeedback['reqfd_reply']=='' || $role==1 ){
                      ?>
                        <div class="form-group row">
                            <input type="submit"  value="Send">
                     </div>                              
                      <?php  
                     //} ?> 
                </form>
             </div>
            </div>    
        </div>
    </div>
  </div>
</div>
</div>
 