<?php include 'header.php'; ?>


<style type="text/css">
  .sson p {
    background: #03A9F4;
    /* width: 45%; */
    text-align: center;
    height: 28px;
}
.sson {
    /* background: #ccc; */
    width: 50%;
    /* float: inherit; */
    margin-bottom: 36px;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Change Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         
                  <!-- /.tab-pane -->
                    <div class="sson"><?php if(isset($_SESSION['message'])){ echo '<p>'.$_SESSION['message'].'</p>'; unset($_SESSION['message']); }?></div>
                 
                    <form class="form-horizontal" action="change_password.php" method="post" style="width: 100%">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="oldpass" class="form-control" id="inputName" placeholder="old password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputEmail" placeholder="New Password"  name="pass" >
                        </div>
                      </div>
                    
                
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Confrim New Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="cpass" class="form-control" id="inputSkills" placeholder="Confrim new password">
                        </div>
                      </div>
                  
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include 'footer.php'; ?>