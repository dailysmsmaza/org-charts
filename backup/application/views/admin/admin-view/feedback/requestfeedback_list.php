<link href="<?php echo base_url('assets/select2/select2.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<?php
$user_id = $this->session->userdata("id");
$role =  $this->session->userdata('role');
?>
<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
  <div class="clshiddenconsec">
   <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
                <div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>             
                  <?php if($role!=1){?>
                  <div class="addbtn adduser"><a href="<?php echo base_url('requestfeedback/send_requestfeedbacks') ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Send Request</a>
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
                     <form method="GET" action="<?php echo base_url('requestfeedback/index/') ?>" class="tablesearchform">                         
                          <input type="text" name="srch_reqfddate" class="form-control datepicker" value="<?php echo isset($_GET["srch_reqfddate"]) ? $_GET["srch_reqfddate"] : '' ; ?>">&nbsp;&nbsp;
                          <input type="text" name="search" placeholder="Search" class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : '' ; ?>">
                          <input  type="submit"  value="Search" class="inpbtn">
                          <a href="<?php echo base_url('requestfeedback') ?>" class="inpbtn">Reset</a>  
                      </form> 
                </div>     
                  <div class=""></div>
                   <table  class="mobiletable userslist-table">            
                      <thead>
                          <tr>
                             <th>Date</th>
                            <?php if($role==1){?>
                              <th>Company</th>
                            <?php } if($role==1 || $role==3){ ?>             
                              <th>From</th>
                            <?php } ?>
                              <th>To</th>
                              <th>Subject</th>
                              <th>Message</th>
                              <th>Reply</th>
                              <th>Status</th>
                              <th>Action</th> 
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          if (!empty($feedbacks)) {
                              foreach ($feedbacks as $feedbacks_value) {
                                  ?>
                                    <?php
                                          $userid =  $feedbacks_value["reqfd_id"];
                                          $usrcompany=$feedbacks_value["company_id"];
                                          $username = ''; $num = 0;
                                          if($userid){
                                            $username = get_userinfo($userid, 'first_name', 'id');
                                            $usercmpname = get_userinfo($usrcompany, 'first_name', 'id');
                                              $query =  $this->db->query('SELECT * FROM requestfdbck_master WHERE reqfd_id = '.$userid);
                                              $num = $query->num_rows();
                                              
                                          }
                                          $status = "";
                                          ($feedbacks_value["reqfd_status"] == 0) ? $status = 1 : $status = 0;
                                       ?>
                                  <tr>
                                    <?php 

                                    $reqfd_createddate = (trim($feedbacks_value['reqfd_createddate']) && $feedbacks_value['reqfd_createddate'] != '0000-00-00')?date('d M, Y', strtotime($feedbacks_value['reqfd_createddate'])):'-';

                                    $reqfd_updateddate = (trim($feedbacks_value['reqfd_updateddate']) && $feedbacks_value['reqfd_updateddate'] != '0000-00-00')?date('d M, Y', strtotime($feedbacks_value['reqfd_updateddate'])):'-';
                                    
                                    /*if($feedbacks_value['reqfd_reply']!=''){
                                      ?>
                                        <td style="word-wrap:break-word; width: 110px "><?php echo $reqfd_updateddate; ?></td>
                                      <?php
                                    }else{
                                    ?><td style="word-wrap:break-word; width: 110px "><?php echo $reqfd_createddate; ?></td>
                                  <?php }*/ ?>
                                  <td><?php echo $reqfd_createddate; ?></td>
                                    <?php if($role==1){?>
                                      <td><?php
                                     if($usercmpname['first_name']==''){
                                            echo $feedbacks_value['reqfd_userfrom'];
                                          }else{
                                             echo $usercmpname['first_name'];
                                          } 
                                     ?></td>
                                    <?php } if($role==1 || $role==3){ ?> 
                                    <td><?php 
                                    echo $feedbacks_value["reqfd_userfrom"]; ?></td>
                                    <?php }?>
                                    <td><?php echo $feedbacks_value["reqfd_userto"]; ?></td>
                                    <td><?php echo $feedbacks_value["reqfd_subject"]; ?></td>
                                    <td><?php echo $feedbacks_value["reqfd_message"]; ?></td>
                                    <td><?php echo $feedbacks_value["reqfd_reply"]; ?></td>
                                    
 
                                      <td class="<?php echo ($feedbacks_value["reqfd_status"] == 0) ? 'activestatus' : 'deactivestatus' ?>"><?php echo ($feedbacks_value["reqfd_status"] == 0) ? "Completed" : "Pending" ?></td>
                                      
                                      <td class="action-td">
                                       <a class="actionicon editicon"  href="<?php echo base_url('requestfeedback/edit/' . $feedbacks_value['reqfd_id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                       <?php if(($feedbacks_value["reqfd_createdby"]==$user_id && $feedbacks_value["reqfd_status"] == 1) || ($role==1) ){
                                       ?>
                                         <a class="actionicon deleteicon show-alert" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('requestfeedback/delete/' . $feedbacks_value['reqfd_id']) ?>"><i class="fa fa-trash" aria-hidden="true" ></i></a>
                                      </td>
                                       <?php 
                                       } ?>
                                      
                                  </tr>
                              <?php
                                }
                            } else {
                              ?>
                                <tr><td colspan="9">Not Data Found</td></tr>
                        <?php } ?>
                        <tr><td colspan="9">Total Record (s) : <?php echo $total_requestfeedback ?></td></tr>
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