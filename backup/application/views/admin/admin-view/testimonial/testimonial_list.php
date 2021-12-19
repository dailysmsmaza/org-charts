<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
  <div class="clshiddenconsec">
   <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>
                  <div class="addbtn adduser"><a href="<?php echo base_url('testimonial/add_testimonial') ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Add Testimonial</a></div>
              </div>
              <?php if ($this->session->flashdata("success")) { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success"); ?>
                    </div>
                <?php } ?>  
              <div class="whitebox">
              	<div class=""></div>
                <table class="mobiletable userslist-table">
                    <thead>                        
                        <tr>            
                            <th>User</th>
                            <th>Message</th>            
                            <th>Status</th>
                            <th>Action</th>	
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($testimonial)) {
                            foreach ($testimonial as $testimonial_list) {
                                ?>
                                <tr>
                                    <td><?php echo $testimonial_list["first_name"]." ".$testimonial_list["last_name"]; ?></td>
                                    <td><?php echo $testimonial_list["message"] ?></td>
                                    <td class="<?php echo ($testimonial_list["status"] == 1) ? 'activestatus' : 'deactivestatus' ?>"><?php echo ($testimonial_list["status"] == 1) ? "Active" : "Deactive" ?></td>
                                    <td class="action-td">
                                        <?php
                                        $status = "";
                                        ($testimonial_list["status"] == 1) ? $status = 0 : $status = 1;
                                        ?>                            
                                        <a class="actionicon activeicon" href="<?php echo base_url('testimonial/changestatus/' . $status . '/' . $testimonial_list['testimonial_id']) ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        <a class="actionicon editicon"  href="<?php echo base_url('testimonial/edit/' . $testimonial_list['testimonial_id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a class="actionicon deleteicon" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('testimonial/delete/' . $testimonial_list['testimonial_id']) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td>Not Data Found</td></tr>
                        <?php } ?>
                        <tr><td colspan="7">Total Record (s) : <?php echo $total_testimonial ?></td></tr>
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
