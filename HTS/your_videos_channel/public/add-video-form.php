<?php 
    include('public/fcm.php');
	require_once("public/thumbnail_images.class.php");

 	if(isset($_POST['submit'])) {

		$video_id = 'cda11up';

		if($_POST['upload_type'] == 'Upload') {

			$video_thumbnail = time().'_'.$_FILES['video_thumbnail']['name'];
			$pic2			 = $_FILES['video_thumbnail']['tmp_name'];
			$tpath2			 = 'upload/'.$video_thumbnail;
			copy($pic2, $tpath2);

			$video 	= time().'_'.$_FILES['video']['name'];
			$pic1	= $_FILES['video']['tmp_name'];
			$tpath1	='upload/video/'.$video;
			copy($pic1, $tpath1);
			$bytes = $_FILES['video']['size'];

	        if ($bytes >= 1073741824) {
	            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
	        }

	        else if ($bytes >= 1048576) {
	            $bytes = number_format($bytes / 1048576, 2) . ' MB';
	        }

	        else if ($bytes >= 1024) {
	            $bytes = number_format($bytes / 1024, 2) . ' KB';
	        }

	        else if ($bytes > 1) {
	            $bytes = $bytes . ' bytes';
	        }

	        else if ($bytes == 1) {
	            $bytes = $bytes . ' byte';
	        } else {
	            $bytes = '0 bytes';
	        }
			

		} else if ($_POST['upload_type'] == 'Url') {

			$video = $_POST['url_source'];

			$video_thumbnail = time().'_'.$_FILES['image']['name'];
			$pic2			 = $_FILES['image']['tmp_name'];
			$tpath2			 = 'upload/'.$video_thumbnail;
			copy($pic2, $tpath2);

		} else {
			$video = $_POST['youtube'];
			$video_thumbnail = '';		

			function youtube_id_from_url($url) {

		    	$pattern = 
		        '%^# Match any youtube URL
		        (?:https?://)?  # Optional scheme. Either http or https
		        (?:www\.)?      # Optional www subdomain
		        (?:             # Group host alternatives
		          youtu\.be/    # Either youtu.be,
		        | youtube\.com  # or youtube.com
		          (?:           # Group path alternatives
		            /embed/     # Either /embed/
		          | /v/         # or /v/
		          | /watch\?v=  # or /watch\?v=
		          )             # End path alternatives.
		        )               # End host alternatives.
		        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
		        $%x'
		        ;

			    $result = preg_match($pattern, $url, $matches);

			    if (false !== $result) {
			        return $matches[1];
			    }
		    	return false;

			}

			$video_id = youtube_id_from_url($_POST['youtube']);

		}

                $data = array(

					'cat_id'  			=> $_POST['cat_id'],			
					'video_title'  		=> addslashes($_POST['video_title']),
					'video_url'  		=> $video,									
					'video_id' 			=> $video_id,
					'video_thumbnail' 	=> $video_thumbnail,									
					'video_duration' 	=> $_POST['video_duration'],
                    'video_description' => addslashes($_POST['video_description']),
					'video_type' 		=> $_POST['upload_type'],
					'size' 				=> $bytes
					);		

 					  $qry = Insert('tbl_gallery', $data);									
                      
  					  $_SESSION['msg'] = "";
					  header( "Location:add-video.php");
					  exit;

 	}

	$wall_qry = "SELECT * FROM tbl_category";
	$wall_result = mysqli_query($connect, $wall_qry);

?>

<script type="text/javascript">

	$(document).ready(function(e) {

	    $("#upload_type").change(function() {
			var type = $("#upload_type").val();

				if (type == "youtube") {
					$("#video_upload").hide();
					$("#direct_url").hide();
					$("#youtube").show();
				}

				if (type == "Url") {
					$("#youtube").hide();
					$("#video_upload").hide();
					$("#direct_url").show();
				}

				if (type == "Upload") {
					$("#youtube").hide();
					$("#direct_url").hide();
					$("#video_upload").show();
				}						
		});

		$( window ).load(function() {
		var type=$("#upload_type").val();

			if (type == "youtube")	{
				$("#video_upload").hide();
				$("#direct_url").hide();
				$("#youtube").show();
			}

			if (type == "Url") {
				$("#youtube").hide();
				$("#video_upload").hide();
				$("#direct_url").show();
			}

			if (type == "Upload") {
				$("#youtube").hide();
				$("#direct_url").hide();
				$("#video_upload").show();
			}

		});

	});

</script>

	<!-- START CONTENT -->
    <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          	<div class="container">
            	<div class="row">
              		<div class="col s12 m12 l12">
               			<h5 class="breadcrumbs-title">Add New Video</h5>
		                <ol class="breadcrumb">
		                  <li><a href="dashboard.php">Dashboard</a></li>
		                  <li><a href="manage-video.php">Manage Video</a></li>
		                  <li><a class="active">Add New Video</a></li>
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
		        		<div class="card-panel">
		                	<div class="row">
		                 		<form method="post" id="form-validation" enctype="multipart/form-data">
		                  			<div class="row">
		                  			   
		                    			<div class="input-field">

			                    			<div class="col s12 m12 l12">
				                    			<?php if(isset($_SESSION['msg'])) { ?>
				                    			<div class="col s12 m12 l12">
													<div class="card-panel teal lighten-2">
													    <span class="white-text text-darken-2">
														New Video Added Successfully...
														</span>
													</div>
												</div>
												<?php unset($_SESSION['msg']); } ?>
											</div>

			                    		<div class="col s12 m12 l5"> 
												
											<div class="col s12 m12 l12"> 
												<div class="row">
													<div class="input-field col s12">
													    <input type="text" name="video_title" id="video_title" placeholder="Video Title" required/>
													    <label for="video_title">Video Title</label>
													</div>
												</div>
											</div>

											<div class="col s12 m12 l12"> 
												<div class="row">
													<div class="input-field col s12">
													    <input type="text" name="video_duration" id="video_duration" placeholder="03:59" required/>
													    <label for="video_duration">Video Duration</label>
													</div>
												</div>
											</div>

											<div class="col s12 m12 l12"> 
												<div class="row">
													<div class="input-field col s12">
													    <select name="cat_id" id="cat_id">
															<?php while ($data = mysqli_fetch_array ($wall_result)) { ?>
															<option value="<?php echo $data['cid'];?>"><?php echo $data['category_name'];?></option>
															<?php } ?>
														</select>
													    <label for="cat_id">Category</label>
													</div>
												</div>
											</div>

											<div class="col s12 m12 l12"> 
												<div class="row">
													<div class="input-field col s12">
													    <select name="upload_type" id="upload_type">
															<option value="youtube">Youtube</option>
															<option value="Url">Url</option>
															<option value="Upload">Upload</option>
														</select>
													    <label for="upload_type">Upload Type</label>
													</div>
												</div>
											</div>

											<div id="youtube" class="col s12 m12 l12"> 
												<div class="row">
													<div class="input-field col s12">
													    <input type="text" name="youtube" id="youtube" placeholder="https://www.youtube.com/watch?v=33F5DJw3aiU" required/>
													    <label for="youtube">Youtube URL</label>
													</div>
												</div>
											</div>

											<div id="video_upload" class="col s12 m12 l12">
												<div class="row">
													<div class="input-field col s12">
													    <input type="file" id="input-file-now" name="video_thumbnail" id="video_thumbnail" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg png gif"/>
													</div>
												</div>

												<div class="row">
													<div class="input-field col s12">
													    <input type="file" id="input-file-now" name="video" id="video" class="dropify-video" data-allowed-file-extensions="3gp mp4 mpg wmv mkv m4v mov flv"/>
													</div>
												</div>
	                                        </div>

	                                        <div id="direct_url" class="col s12 m12 l12">

												<div class="row">
													<div class="input-field col s12">
													    <input type="file" id="input-file-now" name="image" id="image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg png gif"/>
													    <br>
													</div>
												</div>

												<div class="row">
													<div class="input-field col s12">
													    <input type="text" name="url_source" id="url_source" placeholder="http://www.xyz.com/video_title.mp4" required/>
													    <label for="youtube">Video URL</label>
													</div>
												</div>
	                                        </div>

                                        </div>

                                        <div class="col s12 m12 l7">
                                        	<div class="row">
								                <div class="input-field col s12">
									                <span class="grey-text text-grey lighten-2">Description</span>
													<textarea name="video_description" id="video_description" class="form-control" cols="60" rows="10"></textarea>
													<script>                             
														CKEDITOR.replace( 'video_description' );
													</script>		
												</div>
								            </div>

								            <br>
								            <button class="btn cyan waves-effect waves-light right"
	                                                type="submit" name="submit">Submit
	                                            <i class="mdi-content-send right"></i>
	                                        </button>

                                        </div>


                                    </div>
						            </div>
						        </form>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>