<?php include 'header.php'; ?>
<?php include 'connect.php' ; ?>




<style type="text/css">
.point {
    margin-top: 100px;
    background: #ccc;
    padding: 20px;
}
.email {
    margin-top: 100px;
    background: #ccc;
    padding: 20px;
}
.email h1 {
    margin-bottom: 40px;
}
.point h1 {
    margin-bottom: 40px;
}
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

<div class="email">
  
  <h1>Default Email</h1>
  <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
    <thead>
      <tr>
        <th>Email</th>
        <th>Action</th>

      </tr>
    </thead>
    <tbody>
      <?php 
      $res=mysqli_query($conn,"SELECT * FROM config WHERE type='email'");
   
              while($row=mysqli_fetch_array($res)){
                ?>
                <tr>
                  <td><?php echo $row['froms']; ?></td>
                  <td><button class="btn btn-primary" data-toggle="modal" data-target="#updateemail<?php echo $row['id']; ?>"> Edit</button></td>
                </tr>



<div class="modal fade" id="updateemail<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Edit Default Email</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

       <form action="set_default_form.php" method="POST" >

         <div class="inp">

           <input type="hidden" name="type" value="editemail">

           <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

           <input type="text" name="email" placeholder="Defaul Email" value="<?php echo $row['froms']; ?>">

          

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



                <?php
              }
         

       ?>
    </tbody>
  </table>
</div>

   

   



   <div class="point">
  
  <h1>Default Referal Points</h1>
  <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
    <thead>
      <tr>
        <th>Points</th>
        <th>Action</th>

      </tr>
    </thead>
    <tbody>
      <?php 
      $res=mysqli_query($conn,"SELECT * FROM config WHERE type='point'");
   
              while($row=mysqli_fetch_array($res)){
                ?>
                <tr>
                  <td><?php echo $row['froms']; ?></td>
                  <td><button class="btn btn-primary" data-toggle="modal" data-target="#updatepoint<?php echo $row['id']; ?>"> Edit</button></td>
                </tr>



<div class="modal fade" id="updatepoint<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Edit Default Referal Point</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

       <form action="set_default_form.php" method="POST" >

         <div class="inp">

           <input type="hidden" name="type" value="editpoint">

           <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

           <input type="text" name="email" placeholder="Defaul Email" value="<?php echo $row['froms']; ?>">

          

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



                <?php
              }
         

       ?>
    </tbody>
  </table>
</div>









      </div><!-- /.container-fluid -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

<?php include 'footer.php'; ?>