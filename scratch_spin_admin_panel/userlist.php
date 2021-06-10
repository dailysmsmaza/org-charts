<?php include 'header.php' ; ?>
<?php include 'connect.php' ; ?>
<style type="text/css">
  img.im {
    width: 22%;
}
.bt{
  margin-bottom: 16px;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">All User List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All User List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       <!--  <button type="button" class="btn btn-primary bt" data-toggle="modal" data-target="#exampleModal">
  Add New Image
</button> -->

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADD Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="add_all_img.php" method="post" enctype="multipart/form-data">
         <div class="inp">
           <input type="hidden" name="type" value="product">
           <input type="text" name="name" placeholder="product name">
           <input type="file" name="img" >
         </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
         </form>
      </div>
    </div>
  </div>
</div> -->
        <!-- Small boxes (Stat box) -->
        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Points</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $sql="SELECT * FROM users ";
                  $res=mysqli_query($conn,$sql);
                  $i=1;
                  while($row=mysqli_fetch_array($res)){ ?>
                       <tr>
                         <td><?php echo $i; ?></td>
                          <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                             <td><?php echo $row['points']; ?></td>
                            <td><?php if($row['status']==1){ ?>
                                <a href="change_status.php?id=<?php echo $row['id'];?>&status=0"><button class="btn btn-success sml" >Active</button> </a>
                              <?php } else { ?>
                                <a href="change_status.php?id=<?php echo $row['id'];?>&status=1"><button class="btn btn-warning sml" >Blocked</button> </a>
                              <?php } ?></td>
                            <td>
                          
                              <a href="deldata.php?del=user&id=<?php echo $row['id']; ?>">
                                <button class="btn btn-danger sml">Delete</button></a>

                            </td>
                       </tr>







<div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="add_all_img.php" method="post" enctype="multipart/form-data">
         <div class="inp">
           <input type="hidden" name="type" value="updproduct">
           <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
           <input type="text" name="name" placeholder="product name" value="<?php echo $row['name']; ?>">
           <input type="file" name="img" >
         </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
         </form>
      </div>
    </div>
  </div>
</div>








              <?php $i=$i+1; }
             ?>
          </tbody>
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include 'footer.php'; ?>