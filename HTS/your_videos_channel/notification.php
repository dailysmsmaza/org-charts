<?php include('session.php'); ?>
<?php include("public/menubar.php"); ?>

<?php
	include('public/fcm.php');
	include('public/language.php'); 
 	
	$sql_user   = "SELECT COUNT(*) as num FROM tbl_fcm_token";
  	$total_user = mysqli_query($connect, $sql_user);
  	$total_user = mysqli_fetch_array($total_user);
  	$total_user = $total_user['num'];
	
	$rss_qry = "SELECT * FROM tbl_fcm_template ORDER BY id DESC";
	$rss_result = mysqli_query($connect, $rss_qry);
  	 
	
	if (isset($_GET['id'])) {

		$sql = 'SELECT * FROM tbl_fcm_template WHERE id=\''.$_GET['id'].'\'';
  		$img_rss = mysqli_query($connect, $sql);
		$img_rss_row = mysqli_fetch_assoc($img_rss);

		if ($img_rss_row['image'] != "") {
			unlink('upload/notification/'.$img_rss_row['image']);
 		}

		Delete('tbl_fcm_template','id='.$_GET['id'].'');

		header("location: notification.php");
		exit;

 	}
	
	if(isset($_GET['notification_id'])) {				

			$qry = "SELECT * FROM tbl_fcm_template WHERE id = '".$_GET['notification_id']."'";
            $result = mysqli_query($connect, $qry);
            $row = mysqli_fetch_assoc($result);

            $pesan = $row['message'];

            $image = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/upload/notification/'.$row['image'];
            
			$users_sql = "SELECT * FROM tbl_fcm_token"; 

			$users_result = mysqli_query($connect, $users_sql);
			while($user_row = mysqli_fetch_assoc($users_result)) {
			
				$msg = $pesan;
				$img = $image;

				$data = array("title" => $msg, "image" => $img);	
						 
				echo SEND_FCM_NOTIFICATION($user_row['token'], $data);
			
			}

			if ($result) {
				if ($total_user >= 1) {
					$error['send_notification'] = 
						"<div class='card-panel teal lighten-2'>
							<span class='white-text text-darken-2'>
								Congratulations, Push Notification Sent to $total_user Users...
							</span>
						</div>";
				} else {
					$error['send_notification'] = 
						"<div class='card-panel teal lighten-2'>
							<span class='white-text text-darken-2'>
								push notification can not be sent, there is no applications installed on the user's phone....
							</span>
						</div>";
				}
			} else {
					$error['send_notification'] = 
						"<div class='card-panel red darken-1'>
							<span class='white-text text-darken-2'>
								Failed
							</span>
						</div>";
		}
	}
	 
	
 ?>

	<!-- START CONTENT -->
    <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          	<div class="container">
            	<div class="row">
              		<div class="col s12 m12 l12">
               			<h5 class="breadcrumbs-title">Push Notification</h5>
		                <ol class="breadcrumb">
		                  <li><a href="dashboard.php">Dashboard</a>
		                  </li>
		                  <li><a class="active">Push Notification</a>
		                  </li>
		                </ol>
              		</div>
            	</div>
          	</div>
        </div>
        <!--breadcrumbs end-->

        <!--start container-->
        <div class="container">
          	<div class="section">
				<div class="row">
		        	<div class="col s12 m12 l12">
		        	<div align="right"><a href="add-notification.php" class="btn waves-effect waves-light indigo">Add New Template</a></div>
		        		
		        		<div class="card-panel">

							<?php echo isset($error['send_notification']) ? $error['send_notification'] : '';?> <?php echo isset($error['delete_notification']) ? $error['delete_notification'] : '';?>	

							<table id="table_channel" class="responsive-table display" cellspacing="0">
																								         		
							  <thead>
								  <tr>
								  	  <th class="hide-column">ID</th>
								  	  <th width="10%">No.</th>
								      <th width="50%">Message</th>
								      <th width="20%">Image</th>
									  <th width="20%">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
	                
	                            <?php 
									$i = 1;
									while($rss_row=mysqli_fetch_array($rss_result)) {
								?>

				                <tr> 
									<td class="hide-column"><?php echo $rss_row['id'];?></td>
									<td>
					            		<?php
						                    echo $i;
						                    $i++;
						                ?>
					            	</td>
								   	<td><?php echo $rss_row['message'];?></td>
								   	<td>
								   	<?php
								   	if($rss_row['image'] == NULL) {
				      				
				      				?>
				      				<img src="assets/images/no-image.png" height="54px" width="54px"/>
				      				<?php

				  					} else {

				  					?>
								   	<img src="upload/notification/<?php echo $rss_row['image'];?>" height="54px" width="54px"/>
								   	
								   	<?php } ?>

								   	</td>                                  
				                  	<td>

				                  	<a href="edit-notification.php?id=<?php echo $rss_row['id'];?>">
				                      <i class="mdi-editor-mode-edit"></i>
				                    </a>
				                                     
				                    <a href="notification.php?id=<?php echo $rss_row['id'];?>" onclick="return confirm('Are you sure want to delete this template?')">
				                      <i class="mdi-action-delete"></i> 
				                    </a>

				                    &nbsp;
				                    <a href="notification.php?notification_id=<?php echo $rss_row['id'];?>" onclick="return confirm('Send this notification to your users?')">
				                      <i class="mdi-content-send"></i>
				                    </a>
				 
				                  	</td>
				                </tr>
	                				<?php } ?>	  
							  </tbody>
						  </table>

		      			</div>
					</div>
				</div>
			</div>
		</div>

	</section>

<?php include('public/footer.php'); ?>