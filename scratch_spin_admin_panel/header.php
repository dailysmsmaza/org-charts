<?php

session_start();

if(!isset($_SESSION['login'])){

  header('location:login.php');

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Admin | Dashboard</title>



  <!-- Google Font: Source Sans Pro -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Tempusdominus Bootstrap 4 -->

  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- iCheck -->

  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- JQVMap -->

  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- overlayScrollbars -->

  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <!-- Daterange picker -->

  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

  <!-- summernote -->

  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">



  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">



  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->

    <ul class="navbar-nav">

      <li class="nav-item">

        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

      </li>

      <li class="nav-item d-none d-sm-inline-block">

        <a href="index.php" class="nav-link">Home</a>

      </li>

      <!-- <li class="nav-item d-none d-sm-inline-block">

        <a href="#" class="nav-link">Contact</a>

      </li> -->

    </ul>



    <!-- SEARCH FORM -->

    <form class="form-inline ml-3">

      <div class="input-group input-group-sm">

        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">

        <div class="input-group-append">

          <button class="btn btn-navbar" type="submit">

            <i class="fas fa-search"></i>

          </button>

        </div>

      </div>

    </form>



    <!-- Right navbar links -->



  </nav>

  <!-- /.navbar -->



  <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="index.php" class="brand-link">

      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

      <span class="brand-text font-weight-light">Admin</span>

    </a>



    <!-- Sidebar -->

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="image">

          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

        </div>

        <div class="info">

          <a href="#" class="d-block"><?php echo $_SESSION['name']; ?></a>

        </div>

      </div>



      <!-- SidebarSearch Form -->

      <div class="form-inline">

        <div class="input-group" data-widget="sidebar-search">

          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">

          <div class="input-group-append">

            <button class="btn btn-sidebar">

              <i class="fas fa-search fa-fw"></i>

            </button>

          </div>

        </div>

      </div>



      <!-- Sidebar Menu -->

      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Add icons to the links using the .nav-icon class

               with font-awesome or any other icon font library -->

          <li class="nav-item ">

            <a href="index.php" class="nav-link active">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

                Dashboard

               <!--  <i class="right fas fa-angle-left"></i> -->

              </p>

            </a>

<!--             <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="./index.html" class="nav-link active">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Dashboard v1</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="add_pro_img.php" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Add Product Image</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="./index3.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Dashboard v3</p>

                </a>

              </li>

            </ul> -->

          </li>



                 <li class="nav-item">

            <a href="userlist.php" class="nav-link">

              <i class="nav-icon fas fa-user"></i>

              <p>

                App Users List

                <span class="right badge badge-danger">New</span>

              </p>

            </a>

          </li>

           <li class="nav-item">

            <a href="listtransaction.php" class="nav-link">

              <i class="nav-icon fas fa-th"></i>

              <p>

                All Transactions

                <span class="right badge badge-danger">New</span>

              </p>

            </a>

          </li>
<!--                    <li class="nav-item">

            <a href="add_quizz.php" class="nav-link">

              <i class="nav-icon fas fa-th"></i>

              <p>

                Set Quizz

                <span class="right badge badge-danger">New</span>

              </p>

            </a>

          </li> -->

          <li class="nav-item">

            <a href="profile.php" class="nav-link">

              <i class="nav-icon fas fa-key"></i>

              <p>

                Change Password

                

              </p>

            </a>

          </li>
            <li class="nav-item">

            <a href="config.php" class="nav-link">

              <i class="nav-icon fas fa-link"></i>

              <p>

               Default Configuration

                

              </p>

            </a>

          </li>







        <!--   <li class="nav-item">

            <a href="pages/widgets.html" class="nav-link">

              <i class="nav-icon fas fa-th"></i>

              <p>

                Widgets

                <span class="right badge badge-danger">New</span>

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-copy"></i>

              <p>

                Layout Options

                <i class="fas fa-angle-left right"></i>

                <span class="badge badge-info right">6</span>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/layout/top-nav.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Top Navigation</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Top Navigation + Sidebar</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/layout/boxed.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Boxed</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/layout/fixed-sidebar.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Fixed Sidebar</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Fixed Sidebar <small>+ Custom Area</small></p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/layout/fixed-topnav.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Fixed Navbar</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/layout/fixed-footer.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Fixed Footer</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/layout/collapsed-sidebar.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Collapsed Sidebar</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-chart-pie"></i>

              <p>

                Charts

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/charts/chartjs.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>ChartJS</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/charts/flot.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Flot</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/charts/inline.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Inline</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/charts/uplot.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>uPlot</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-tree"></i>

              <p>

                UI Elements

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/UI/general.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>General</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/icons.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Icons</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/buttons.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Buttons</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/sliders.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Sliders</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/modals.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Modals & Alerts</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/navbar.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Navbar & Tabs</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/timeline.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Timeline</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/ribbons.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Ribbons</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-edit"></i>

              <p>

                Forms

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/forms/general.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>General Elements</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/forms/advanced.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Advanced Elements</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/forms/editors.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Editors</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/forms/validation.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Validation</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-table"></i>

              <p>

                Tables

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/tables/simple.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Simple Tables</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/tables/data.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>DataTables</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/tables/jsgrid.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>jsGrid</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-header">EXAMPLES</li>

          <li class="nav-item">

            <a href="pages/calendar.html" class="nav-link">

              <i class="nav-icon far fa-calendar-alt"></i>

              <p>

                Calendar

                <span class="badge badge-info right">2</span>

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="pages/gallery.html" class="nav-link">

              <i class="nav-icon far fa-image"></i>

              <p>

                Gallery

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="pages/kanban.html" class="nav-link">

              <i class="nav-icon fas fa-columns"></i>

              <p>

                Kanban Board

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon far fa-envelope"></i>

              <p>

                Mailbox

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/mailbox/mailbox.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Inbox</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/mailbox/compose.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Compose</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/mailbox/read-mail.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Read</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-book"></i>

              <p>

                Pages

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/examples/invoice.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Invoice</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/profile.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Profile</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/e-commerce.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>E-commerce</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/projects.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Projects</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/project-add.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Project Add</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/project-edit.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Project Edit</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/project-detail.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Project Detail</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/contacts.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Contacts</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/faq.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>FAQ</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/contact-us.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Contact us</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon far fa-plus-square"></i>

              <p>

                Extras

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>

                    Login & Register v1

                    <i class="fas fa-angle-left right"></i>

                  </p>

                </a>

                <ul class="nav nav-treeview">

                  <li class="nav-item">

                    <a href="pages/examples/login.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Login v1</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/register.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Register v1</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/forgot-password.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Forgot Password v1</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/recover-password.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Recover Password v1</p>

                    </a>

                  </li>

                </ul>

              </li>

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>

                    Login & Register v2

                    <i class="fas fa-angle-left right"></i>

                  </p>

                </a>

                <ul class="nav nav-treeview">

                  <li class="nav-item">

                    <a href="pages/examples/login-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Login v2</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/register-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Register v2</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/forgot-password-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Forgot Password v2</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/recover-password-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Recover Password v2</p>

                    </a>

                  </li>

                </ul>

              </li>

              <li class="nav-item">

                <a href="pages/examples/lockscreen.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Lockscreen</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/legacy-user-menu.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Legacy User Menu</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/language-menu.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Language Menu</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/404.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Error 404</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/500.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Error 500</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/pace.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Pace</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/blank.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Blank Page</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="starter.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Starter Page</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-search"></i>

              <p>

                Search

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/search/simple.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Simple Search</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/search/enhanced.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Enhanced</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-header">MISCELLANEOUS</li>

          <li class="nav-item">

            <a href="iframe.html" class="nav-link">

              <i class="nav-icon fas fa-ellipsis-h"></i>

              <p>Tabbed IFrame Plugin</p>

            </a>

          </li>

          <li class="nav-item">

            <a href="https://adminlte.io/docs/3.1/" class="nav-link">

              <i class="nav-icon fas fa-file"></i>

              <p>Documentation</p>

            </a>

          </li>

          <li class="nav-header">MULTI LEVEL EXAMPLE</li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="fas fa-circle nav-icon"></i>

              <p>Level 1</p>

            </a>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-circle"></i>

              <p>

                Level 1

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Level 2</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>

                    Level 2

                    <i class="right fas fa-angle-left"></i>

                  </p>

                </a>

                <ul class="nav nav-treeview">

                  <li class="nav-item">

                    <a href="#" class="nav-link">

                      <i class="far fa-dot-circle nav-icon"></i>

                      <p>Level 3</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="#" class="nav-link">

                      <i class="far fa-dot-circle nav-icon"></i>

                      <p>Level 3</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="#" class="nav-link">

                      <i class="far fa-dot-circle nav-icon"></i>

                      <p>Level 3</p>

                    </a>

                  </li>

                </ul>

              </li>

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Level 2</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="fas fa-circle nav-icon"></i>

              <p>Level 1</p>

            </a>

          </li>

          <li class="nav-header">LABELS</li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon far fa-circle text-danger"></i>

              <p class="text">Important</p>

            </a>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon far fa-circle text-warning"></i>

              <p>Warning</p>

            </a>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon far fa-circle text-info"></i>

              <p>Informational</p>

            </a>

          </li>

        </ul> -->

      </nav>

      <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

  </aside>

