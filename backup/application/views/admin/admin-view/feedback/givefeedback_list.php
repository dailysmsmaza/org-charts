<link href="<?php echo base_url('assets/select2/select2.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<?php
$role =  $this->session->userdata('role');?>
<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
  <div class="clshiddenconsec">
   <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
                <div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>             
                  <?php if($role!=1){?>
                  <div class="addbtn adduser"><a href="<?php echo base_url('givefeedback/give_feedback') ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Send Feedback</a>
                  </div>
                <?php } ?>
                
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

                      <form method="GET" action="<?php echo base_url('givefeedback/index/') ?>" class="tablesearchform">                         
                          <input type="text" name="srch_givedate" class="form-control datepicker" value="<?php echo isset($_GET["srch_givedate"]) ? $_GET["srch_givedate"] : '' ; ?>">&nbsp;&nbsp;
                          <input type="text" name="search" placeholder="Search" class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : '' ; ?>">                           
                          <input  type="submit"  value="Search" class="inpbtn">
                          <a href="<?php echo base_url('givefeedback') ?>" class="inpbtn">Reset</a>  
                      </form>                                    
                  </div>     
                  <div class=""></div>
                   <table  class="mobiletable userslist-table">            
                      <thead>
                          <tr>
                            <th>Date</th>
                            <?php if($role==1){?>
                              <th>Company</th>
                                         
                              <th>From</th>
                            <?php } ?>
                              <th>To</th>
                              <th>Subject</th>
                              <th>Message</th>
                              <?php //if($role==1 || $role==2){
                              ?><th>Action</th> <?php //} ?>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          if (!empty($givefdbck)) {
                              foreach ($givefdbck as $givefdbck_value) {
                                  ?>
                                    <?php
                                          $userid =  $givefdbck_value["givefd_id"];
                                          $username = ''; $num = 0;

                                          $usrcompany=$givefdbck_value["company_id"];
                                          
                                          if($userid){
                                            $username = get_userinfo($userid, 'first_name', 'id');
                                            $usercmpname = get_userinfo($usrcompany, 'first_name', 'id');
                                             $query =  $this->db->query('SELECT * FROM givefdbck_master WHERE givefd_id = '.$userid);
                                              $num = $query->num_rows();
                                              
                                          }
                                          $status = "";
                                          ($givefdbck_value["givefd_status"] == 1) ? $status = 0 : $status = 1;
                                       ?>
                                  <tr>
                                    <?php 
                                    $reqfd_createddate = (trim($givefdbck_value['givefd_createddate']) && $givefdbck_value['givefd_createddate'] != '0000-00-00')?date('d M, Y', strtotime($givefdbck_value['givefd_createddate'])):'-';?>
                                    <td><?php echo $reqfd_createddate; ?></td>
                                    <?php if($role==1){?>
                                      <td><?php
                                      if($usercmpname['first_name']==''){
                                            echo $givefdbck_value['givefd_userfrom'];
                                          }else{
                                             echo $usercmpname['first_name'];
                                          }
                                      ?></td>
                                   <td><?php echo $givefdbck_value["givefd_userfrom"]; ?></td>
                                  <?php } ?>
                                    <td><?php echo $givefdbck_value["givefd_userto"]; ?></td>
                                    <td><?php echo $givefdbck_value["givefd_subject"]; ?></td>
                                    <td><?php echo $givefdbck_value["givefd_message"]; ?></td>
                                    <?php //if($role==1 || $role==2){
                                       ?>
                                      <td class="action-td">
                                        <a class="actionicon editicon"  href="<?php echo base_url('givefeedback/edit/' . $givefdbck_value['givefd_id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a class="actionicon deleteicon show-alert" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('givefeedback/delete/' . $givefdbck_value['givefd_id']) ?>"><i class="fa fa-trash" aria-hidden="true" ></i></a>
                                      </td>
                                       <?php 
                                       //} ?>
                                      
                                  </tr>
                              <?php
                                }
                            } else {
                              ?>
                                <tr><td colspan="7">Not Data Found</td></tr>
                        <?php } ?>
                        <tr><td colspan="7">Total Record (s) : <?php echo $total_givefdbck ?></td></tr>
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
<script src="<?php echo base_url() ?>assets/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
 });
</script>
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