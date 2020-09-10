<?php
if(file_exists('../config.php')) {
    require('../config.php');
} else {
    require('../config-sample.php');
    echo "WARNING: Currently using the sample configuration file. Please make a local copy called config.php to clear this warning.";
}

$usrLanguage = $conf['language'];
require("../locale/locale-$usrLanguage.php");

if(isset($_GET['url'])) {
    if(strpos($_GET['url'], ':') !== false) {
        // Strip port out of DNS name since PiHole does not deal with ports
        $url = substr($_GET['url'], 0, strpos($_GET['url'], ":"));

        // After stripping out port, then we sanitize/escape the input before doing anything with it
        $url = htmlentities($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    } else {
        // There is no port number so we go straight to sanitizing the user input
        $url = htmlentities($_GET['url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

  $url_provided = true;

    if($url == $server_ip) {
        $url = null;
        $url_provided = false;
    }
} else {
  $url_provided = false;
  $url = null;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <title><?php echo $headerMsg; ?></title>

    <!--- Inline styles -->
    <style>
        .container {
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            position: absolute;
        }

        @media(min-width:630px) {
          #alert {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 95%;
          }
        }

        @media(max-width:629px) {
          #alert {
              margin: 3% auto;
              width: 100%;
          }
        }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="alert alert-danger" id="alert" role="alert">
            <h4 class="alert-heading"><i style="margin-right:1%;" class="fas fa-shield-alt"></i><?php echo $headerMsg; ?></h4>
            <p><?php echo $alertMsg; ?>
            <br />
            <br />
            <strong><?php echo $URLDescriptor; ?> </strong><?php if($url_provided) { echo $url; } else { echo "Unknown"; } ?>
            <hr>
            <button onclick='window.location="<?php echo $safeurl; ?>";' type="button" class="btn btn-success btn-lg btn-block"><?php echo $safeButton ?></button>
            <button onclick='window.location="" +
                    "mailto:<?php echo $adminemail; ?>?subject=Website Unblock Request&body=You can use this email to request the administrator to unblock a website. The first two fields have already been filled out for you.\n"+
                    "%0D%0A%0D%0A"+
                    "Requesting IP address: <?php echo $_SERVER['REMOTE_ADDR']; ?>%0D%0A"+
                    "Requested website: <?php echo $url; ?>%0D%0A"+
                    "Reason for unblock: ";' type="button" class="btn btn-primary btn-lg btn-block"><?php echo $requestUnblockButton; ?></button>
            <form action="<?php echo $conf['unblock_url']; ?>">
              <input type="hidden" name="url" value="<?php echo $url; ?>">
              <input type="hidden" name="unblock" value="true">
              <button style="margin-top:1%;" type="submit" class="btn btn-warning btn-lg btn-block"><?php echo $unblockTemporaryButton; ?></button>
            </form>
            <?php

                if($conf['show_tech_info'] == true) {
                  echo <<<EOL
                  <br />
                  <br />
                  <code style="color:gray">$technicalInfoHeader</code>
                  <br />
                  <code style="color:gray">$technicalInfoMsg</code>
EOL;
                }
            ?>
            <?php
              function get_data($url) {
                $ch = curl_init();
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
              }

              $latestVersion = get_data("https://raw.githubusercontent.com/PiPass/bin/master/currentversion");
              
              if($latestVersion != $conf['pipass_v']) {
                echo <<<EOL
                <br />
                <br />
                <a href="https://github.com/PiPass/blockpage/releases/" class="badge badge-info">$updateAvailMsg</a>
EOL;
              } else {
                echo <<<EOL
                <br />
                <br />
                <code>$upToDateMsg</code>
EOL;
              }
            ?>
          </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
