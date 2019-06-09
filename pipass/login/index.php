<?php
$dbLocation = "/opt/pipass/pipass-DB.db";

if(!is_file($dbLocation)) {
    die("Unable to open connection to PiPass database. Perhaps you disabled the administration panel during setup or you deleted the database by accident?");
}

if(isset($_POST['username'])) {
    if(empty($_POST['username'])) {
        $userEmpty = true;
    }

    if(empty($_POST['password'])) {
        $pwEmpty = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/patternfly/3.24.0/css/patternfly.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/patternfly/3.24.0/css/patternfly-additions.min.css">
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                    <div class="card-pf" style="margin-top:5%;padding-bottom:7%;">
                        <header class="login-pf-header">
                        <h1>PiPass Administration Panel</h1>
                        <p><i>Please authenticate to continue.</i></p>
                        </header>
                        <form method="POST">
                        <div class="form-group">
                            <label class="sr-only" for="password">Username</label>
                            <input type="name" name="username" class="form-control  input-lg" id="username" placeholder="Username">
                            <?php
                                if($userEmpty == true) {
                                    echo "<p style='color:red;'>Username cannot be empty.</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="password">Password
                            </label>
                            <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password">
                            <?php
                                if($pwEmpty == true) {
                                    echo "<p style='color:red;'>Password cannot be empty.</p>";
                                }
                            ?>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Log In</button>
                        </form>
                </div><!-- card -->
                </div><!-- col -->
            </div><!-- row -->
            </div><!-- col -->
        </div><!-- row -->
        </div><!-- container -->
            

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/patternfly/3.24.0/js/patternfly.min.js"></script>
</body>
</html>