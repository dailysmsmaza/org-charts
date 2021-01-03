<?php
  include_once('functions.php'); 
?>

<?php

  $sql_category   = "SELECT COUNT(*) as num FROM tbl_category";
  $total_category = mysqli_query($connect, $sql_category);
  $total_category = mysqli_fetch_array($total_category);
  $total_category = $total_category['num'];

  $sql_video   = "SELECT COUNT(*) as num FROM tbl_gallery";
  $total_video = mysqli_query($connect, $sql_video);
  $total_video = mysqli_fetch_array($total_video);
  $total_video = $total_video['num'];

?>
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Dashboard</h5>
                <ol class="breadcrumb">
                  <li><a href="dashboard.php">Dashboard</a>
                  </li>
                  <li><a href="#" class="active">Home</a>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->

        <!--start container-->
        <div class="container">
            <div class="section">

                        <!--card stats start-->
            <div id="card-stats" class="seaction">
              <div class="row">
                            <div class="col s12 m6 l3">
                            <a href="manage-category.php">
                                <div class="card">
                                    <div class="card-content grey white-text">
                                    <br>
                                        <p class="card-stats-title"><i class="mdi-action-view-list"></i> CATEGORY</p>
                                        <h4 class="card-stats-number"><?php echo $total_category;?></h4>
                                        <p class="card-stats-compare"><span class="blue-grey-text text-lighten-5">Total Category</span>
                                        </p>
                                    <br>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col s12 m6 l3">
                            <a href="manage-video.php">
                                <div class="card">
                                    <div class="card-content grey white-text">
                                    <br>
                                        <p class="card-stats-title"><i class="mdi-av-video-collection"></i> VIDEO LIST</p>
                                        <h4 class="card-stats-number"><?php echo $total_video;?></h4>
                                        <p class="card-stats-compare"><span class="blue-grey-text text-lighten-5">Total Video</span>
                                        </p>
                                    <br>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col s12 m6 l3">
                            <a href="notification.php">
                                <div class="card">
                                    <div class="card-content grey white-text">
                                    <br>
                                        <p class="card-stats-title"><i class="mdi-social-notifications"></i> PUSH NOTIFICATION</p>
                                        <h4 class="card-stats-number"><i class="mdi-social-notifications"></i></h4>
                                        <p class="card-stats-compare"><span class="blue-grey-text text-lighten-5">Notify Your Users</span>
                                        </p>
                                    <br>
                                    </div>
                                </div>
                            </a>
                            </div>                              

                            <div class="col s12 m6 l3">
                            <a href="settings.php">
                                <div class="card">
                                    <div class="card-content grey white-text">
                                    <br>
                                        <p class="card-stats-title"><i class="mdi-action-settings"></i> SETTINGS</p>
                                        <h4 class="card-stats-number"><i class="mdi-action-settings"></i></h4>
                                        <p class="card-stats-compare"><span class="blue-grey-text text-lighten-5">Manage Settings</span>
                                        </p>
                                    <br>
                                    </div>
                                </div>
                            </a>
                            </div>                           
                           
                        </div>
            </div>
            <!--card stats end-->
    </div>
</div>