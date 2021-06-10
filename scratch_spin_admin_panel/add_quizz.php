<?php include 'header.php' ; ?>
<?php include 'connect.php' ; ?>
<style type="text/css">
  img.im {
    width: 22%;
}
.bt{
  margin-bottom: 16px;
}
button.btn {
    margin-right: 10px;
}
.row.ans {
    margin-top: 20px;
}
.inputans{
  margin-top: 5px
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <?php if(!isset($_GET['cat_id'])) { ?> <h1 class="m-0">SELECT CATEGORY</h1> <?php } else { ?><h1 class="m-0">List of Questions</h1> <?php } ?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">select category</li>
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

        <?php if(!isset($_GET['cat_id'])){ ?>
        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
          <thead>
            <tr>
              <th>Id</th>
              <th>Category</th>
              
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $sql="SELECT * FROM quiz_category ";
                  $res=mysqli_query($conn,$sql);
                  if(mysqli_num_rows($res)>=1){
                  $i=1;
                  while($row=mysqli_fetch_array($res)){ ?>
                       <tr>
                         <td><?php echo $i; ?></td>
                          <td><?php echo $row['cat_name']; ?></td>
                          

                            <td>
                             <!--  <button class="btn btn-secondary sml" data-toggle="modal" data-target="#updateModal<?php echo $row['id']; ?>">Edit</button> -->
                              <a href="?cat_id=<?php echo $row['id']; ?>">
                                <button class="btn btn-primary sml">Check</button></a>
                            </td>
                       </tr>

              <?php $i=$i+1; } }
              else{
                  echo '  <tr> NO Record Yet !</tr>';
              }
             ?>
          </tbody>
        </table>
      <?php } ?>
      <?php if(isset($_GET['cat_id'])){ $cat_id=$_GET['cat_id']; ?>
      <div class="bt"><button class="btn btn-primary" data-toggle="modal" data-target="#addmodal">Add Question</button></div>

                    <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
          <thead>
            <tr>
              <th>Id</th>
              <th>Question</th>
              
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $sql="SELECT * FROM questions WHERE cat_id='$cat_id' ";
                  $res=mysqli_query($conn,$sql);
                  if(mysqli_num_rows($res)>=1){
                  $i=1;
                  while($row=mysqli_fetch_array($res)){ 
                        $ans=array();
                        $q_id=$row['q_id'];
                        $resans=mysqli_query($conn,"SELECT * FROM answers WHERE q_id='$q_id'");
                        $j=1;
                        while($rowans=mysqli_fetch_array($resans)){
                            $ans[$j]=$rowans['answer'];
                            $j=$j+1;
                        }
                   ?>
                       <tr>
                         <td><?php echo $i; ?></td>
                          <td><?php echo $row['question']; ?></td>
                          

                            <td>
                             <!--  <button class="btn btn-secondary sml" data-toggle="modal" data-target="#updateModal<?php echo $row['id']; ?>">Edit</button> -->
                          
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewmodal">View</button><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editmodal">Edit</button>
                            </td>
                       </tr>


                       <!-- Modal -->
<div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Question/Answer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row"><b>Question :</b> <p><?php echo $row['question'] ?></p></div>
      <div class="row">
        <div class="col-sm-6">Answer A :<?php echo $ans[1]; ?></div>
        <div class="col-sm-6">Answer B :<?php echo $ans[2]; ?></div>
      </div>
        <div class="row">
        <div class="col-sm-6">Answer C :<?php echo $ans[3]; ?></div>
        <div class="col-sm-6">Answer D :<?php echo $ans[4]; ?></div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="inert_quizz.php" method="post">
      <input type="hidden" name="edit">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Answer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
           <div class="modal-body">
      <div class="row"><b>Question :</b> <input class="ques" type="text" name="question" placeholder="add question" value="<?php echo $row['question']; ?>"></div>
      <div class="row ans">
        <div class="col-sm-6">Answer A :<input type="text" class="inputans" required  name="ans1" placeholder="Add Answer A" value="<?php echo $ans[1]; ?>"></div>
        <div class="col-sm-6">Answer B :<input type="text" class="inputans" required name="ans2" placeholder="Add Answer B" value="<?php echo $ans[2]; ?>"></div>
      </div>
        <div class="row ans">
        <div class="col-sm-6">Answer C :<input type="text" class="inputans" required name="ans3" placeholder="Add Answer C" value="<?php echo $ans[3]; ?>"></div>
        <div class="col-sm-6">Answer D :<input type="text" class="inputans" required name="ans4" placeholder="Add Answer D" value="<?php echo $ans[4]; ?>"></div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
</form>
  </div>
</div>


              <?php $i=$i+1; 

            } }
              else{
                  echo '  <tr> NO Record Yet !</tr>';
              }
             ?>
          </tbody>
        </table>

  <?php    } ?>
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









<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="inert_quizz.php" method="post">
      <input type="hidden" name="add">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Question/Answer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row"><b>Question :</b> <input class="ques" type="text" name="question" placeholder="add question"></div>
      <div class="row ans">
        <div class="col-sm-6">Answer A :<input type="text" class="inputans" required  name="ans1" placeholder="Add Answer A"></div>
        <div class="col-sm-6">Answer B :<input type="text" class="inputans" required name="ans2" placeholder="Add Answer B"></div>
      </div>
        <div class="row ans">
        <div class="col-sm-6">Answer C :<input type="text" class="inputans" required name="ans3" placeholder="Add Answer C"></div>
        <div class="col-sm-6">Answer D :<input type="text" class="inputans" required name="ans4" placeholder="Add Answer D"></div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </form>
  </div>
</div>

<?php include 'footer.php'; ?>