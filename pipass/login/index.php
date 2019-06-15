<?php
session_start();

ini_set('display_errors', 1);
$dbLocation = "/opt/pipass/pipass-DB.db";

// Check if we can connect to the database. If not, kill the program with an error message

if(!is_file($dbLocation)) {
    die("Unable to open connection to PiPass database. Perhaps you disabled the administration panel during setup or you deleted the database by accident?");
}

if(isset($_POST['username'])) {
    // Fill in values on POST (login attempt) so as to avoid errors being shown unnecessarily
    // These variables will be overwritten later in the code.

    //$GLOBALS["pwIncorrect"] = null;

    authenticate($_POST['username'], $_POST['password']);
}

function authenticate($username, $password) {
    $sqlite = new PDO('sqlite:/opt/pipass/pipass-DB.db');
    $userInfo = $sqlite->query("SELECT * FROM USERS WHERE USERNAME = '$username'");
    $DBQueryArray = $userInfo->fetchAll();

    // DBQueryArray is an array which contains information from the PiPass Database about the user that
    // you are trying to log in as. Below is the format for querying the database.

    // $DBQueryArray[0][0]: User ID
    // $DBQueryArray[0][1]: User's First Name
    // $DBQueryArray[0][2]: User's Last Name
    // $DBQueryArray[0][3]: Access Level (0: Read Only / 1: Administrator)
    // $DBQueryArray[0][4]: Username
    // $DBQueryArray[0][5]: Password Hash

    try {
        // Don't show a PHP warning if the PDO query fails because the user is invalid.
        set_error_handler(function() { /* ignore errors */ });
        $userPwHash = $DBQueryArray[0][5];
        restore_error_handler();
    } catch(Exception $e) {
        // The user specified does not exist
        $GLOBALS["userexists"] = false;
    }

    $GLOBALS["pwIncorrect"] = false;

    if(password_verify($password, $userPwHash)) {
        $_SESSION["username"] = $username;
        header("Location: ../manage/");
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
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="password">Password
                            </label>
                            <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password">
                            <?php
                                if(isset($_POST['username'])) {
                                    if($GLOBALS["pwIncorrect"] == 1222 || empty($_POST["password"])) {
                                        echo "PW Incorrect: ".$GLOBALS["pwIncorrect"];
                                        echo "<p style='color:red;margin-top:2%;'>The username and password did not match. Please try again.</p>";
                                    }
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