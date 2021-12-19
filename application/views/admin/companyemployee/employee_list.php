<link href="<?php echo base_url('assets/select2/select2.min.css') ?>" rel="stylesheet">
<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
    <div class="clshiddenconsec">
        <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $heading_title ;
                        $companyid = $this->uri->segment(3);
                    ?>                    
                  </h2>

                  <div class="addbtn adduser"><a href="<?php echo base_url('company/add_companyemployee/').$companyid ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Add Employee</a></div>
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
                    <?php 
                    if($this->session->userdata("role") == 1){
                    ?> 
                    <div class="tablesearch">
                        <div class="depratmentfilter">
                            <select name="departmentfilter" id="departmentfilter" class="select2">
                                <option value="">Filter by Department</option><?php
                                $departmentid = isset($_GET["department"]) ? $_GET["department"] : "" ;
                                $query = $this->db->query("SELECT * FROM department_master WHERE status = 1 AND company_id = ".$companyid." ORDER BY name ASC");
                                if($query->num_rows()){
                                    foreach ($query->result() as $user) { ?>
                                        <option <?=($departmentid == $user->id)?'selected':'';?> value="<?=$user->id;?>"><?=$user->name;?></option><?php
                                    }
                                } ?>
                            </select>
                        </div>

                        <form method="GET" action="<?php echo base_url('company/view_employee/'.$company_id) ?>" class="tablesearchform">                          
                            <input type="text" name="search" placeholder="Search" required="" class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : '' ; ?>">                           
                            <input  type="submit"  value="Search" class="inpbtn">
                            <a href="<?php echo base_url('company/view_employee/'.$company_id) ?>" class="inpbtn">Reset</a>  
                        </form>                                    
                    </div>         
                    <?php } ?>                                  
                <table class="mobiletable userslist-table">
                    <thead>                
                        <tr>
                            <th>Role</th>
                            <!-- <th>Company</th> -->
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Access</th>
                            <th>Phone</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($employee_list)) {
                            foreach ($employee_list as $employee_value) {
                                $departmentname = '-';
                                if($employee_value['department_id']){
                                  $dquery = $this->db->query("SELECT * FROM department_master WHERE id = ".$employee_value['department_id']);
                                  $drow = $dquery->row();
                                  $departmentname = ($drow)?$drow->name:'-';
                                }
                                
                                $start_date = (trim($employee_value['start_date']) && $employee_value['start_date'] != '0000-00-00')?date('d M, Y', strtotime($employee_value['start_date'])):'-'; ?>
                                <tr>
                                    <td><?php echo get_userrole_name($employee_value["id"]);?></td>
                                    <!-- <td><?php echo  get_anycolunm_anycondition("user_master","first_name","id",$employee_value["company"])." ".get_anycolunm_anycondition("user_master","last_name","id",$employee_value["company"])?></td> -->
                                    <td><?php 
                                     if($employee_value['id']!=''){
                                        $usrceo = get_userinfo($employee_value['id'], 'ceo', 'id');
                                   } 
                                   if($usrceo['ceo']!=1){
                                    echo $employee_value["first_name"]; 
                                        }else{
                                        echo $employee_value["first_name"].' - CEO';
                                    }?>
                                    </td>
                                    <td><?php echo $employee_value["last_name"] ?></td>
                                    <td><?php echo $employee_value["email"] ?></td>
                                    <td align="center"><?php echo $departmentname; ?></td>
                                    <td><?php 
                                        if($employee_value['access_level']==0){
                                            echo "Basic";
                                        }elseif($employee_value['access_level']==1)
                                        {
                                            echo "Team lead";
                                        }elseif($employee_value['access_level']==2){
                                            echo "Administrator";
                                        }
                                         ?></td>
                                    <td><?php echo $employee_value["phone"] ?></td>
                                    <td align="center"><?php echo $start_date ?></td>
                                    <td class="<?php echo ($employee_value["status"] == 1) ? 'activestatus' : 'deactivestatus' ?>"><?php echo ($employee_value["status"] == 1) ? "Active" : "Deactive" ?></td>
                                    <td class="action-td">
                                        <?php
                                        $status = "";
                                        ($employee_value["status"] == 1) ? $status = 0 : $status = 1;
                                        ?>                            
                                        <a class="actionicon activeicon" href="<?php echo base_url('company/changestatus_companyemployee/' . $status . '/' . $employee_value['id'].'/'.$companyid) ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        <a class="actionicon editicon" href="<?php echo base_url('company/edit_companyemployee/' . $employee_value['id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a class="actionicon deleteicon" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('company/delete_companyemployee/' . $employee_value['id'].'/'.$companyid) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="9">Not Data Found</td></tr>
                        <?php } ?>
                        <tr><td colspan="10">Total Record (s) : <?php echo $total_employee ?></td></tr>
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

      $('#departmentfilter').change(function(){
        var id = $(this).val();
        id = (id)?'?department='+id:'';
        window.location.href = '<?=base_url('company/view_employee/'.$companyid);?>'+id;
      });
  });
   setTimeout(function () {
                $(".alert-danger").hide()
            }, 3000);
            setTimeout(function () {
                $(".alert-success").hide()
            }, 3000);
</script>
<script src="<?php echo base_url('assets/select2/select2.full.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();
    });
</script>