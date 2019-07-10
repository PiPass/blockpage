<?php
session_start();

if(!$_SESSION) {
  header("Location: needlogin.html");
  die("User not logged in.");
}

// User is logged in, grab user information and store it in variables.
$username = $_SESSION["username"];

ini_set('display_errors', 1);
$dbLocation = "/opt/pipass/adminpanel.db";

if(!file_exists("$dbLocation")) {
  echo "Your PiPass database is missing or the path is not correctly set. Please create an issue. A detailed error report is below: <br>";
  die("Application exited due to fatal error: Unable to read database at $dbLocation. Does it exist?");
}

$sqlite = new PDO("sqlite:$dbLocation");
$userInfo = $sqlite->query("SELECT * FROM USERS WHERE USERNAME = '$username'");
$DBQueryArray = $userInfo->fetchAll();

    // DBQueryArray is an array which contains information from the PiPass Database about the user that
    // is currently logged in. Do not use this variable for querying other users in the case of a superadmin.
    // Below is the format for querying the database.

    // $DBQueryArray[0][0]: User ID
    // $DBQueryArray[0][1]: User's First Name
    // $DBQueryArray[0][2]: User's Last Name
    // $DBQueryArray[0][3]: Access Level (0: Read Only / 1: Administrator / 2: Super Administrator)
    // $DBQueryArray[0][4]: Username
    // $DBQueryArray[0][5]: Password Hash

$firstname = $DBQueryArray[0][1];
$lastname = $DBQueryArray[0][2];

switch ($DBQueryArray[0][3]) {
  case 0:
    $accesslevel = "READONLY";
    break;
  case 1:
    $accesslevel = "ADMINISTRATOR";
    break;
  case 2:
    $accesslevel = "SUPERADMINISTRATOR";
    break;
  default:
    echo "Your PiPass database is corrupted. Please create an issue. A detailed error report is below: <br>";
    die("Application exited due to fatal error: Unable to read database at $dbLocation. Failed reading column ACCESS in USERS table.");
}

switch ($accesslevel) {
  case "READONLY":
    $alreadable = "Read-only";
    break;
  case "ADMINISTRATOR":
    $alreadable = "Administrator";
    break;
  case "SUPERADMINISTRATOR":
    $alreadable = "Super Administrator";
    break;
}
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PiPass Administration</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>PPA</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PiPass</b>Admin</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><?php echo $firstname." ".$lastname; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <p>
                  <?php echo $firstname." ".$lastname; ?>
                  <small><?php echo $alreadable; ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="../../login/deauth.php" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../dist/img/pipass-arrow.jpg" class="img-circle">
        </div>
        <div class="pull-left info">
          <p><?php echo $firstname." ".$lastname; ?></p>
          <!-- Status -->
          <?php
            switch ($accesslevel) {
              case "READONLY":
                echo <<<EOL
                <i style="margin-right: 3%;" class="fa fa-eye"></i> $alreadable
EOL;
                break;
              case "ADMINISTRATOR":
                echo <<<EOL
                <i style="margin-right: 3%;" class="fa fa-check"></i> $alreadable
EOL;
                break;
              case "SUPERADMINISTRATOR":
                echo <<<EOL
                <i style="margin-right: 3%;" class="fa fa-wrench"></i> $alreadable
EOL;
                break;
            } 
          ?>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">PAGES</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href=".."><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="../requests"><i class="fa fa-check"></i> <span>Requests</span></a></li>
        <li class="active"><a><i class="fa fa-users"></i> <span>Users</span></a></li>
        <li><a href="../settings"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users & Groups Management
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <a style="margin-right:0.5%;" href="https://github.com/roenw/PiPass">GitHub</a><a style="margin-right:0.5%;" href="https://apps.roen.us/pipass/docs/">Docs</a><a style="margin-right:0.5%;" href="https://github.com/roenw/PiPass/graphs/contributors">Contributors</a>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>