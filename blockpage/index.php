<?php
require('../config.php');

$usrLanguage = $conf['language'];
require("../locale/locale-$usrLanguage.php");

$safeurl = $conf['safeurl'];
$adminemail = $conf['adminemail'];

$hostname = gethostname();
$server_ip = $_SERVER['SERVER_ADDR']; 
$pipass_v = $conf['pipass_v'];

if(isset($_GET['url'])) {
  $url = $_GET['url'];
  $GLOBALS['url'] = $_GET['url'];
  $url_provided = true;
} else {
  $url_provided = false;
}

if($url == $server_ip) {
  $url = null;
  $url_provided = false;
}
?>

<!doctype html>
<html lang="en">
  <head>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <title>Webpage Blocked</title>

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
            margin-left: auto;
            margin-right: auto;
            margin-top: 3%;
            margin-bottom: 3%;
            width: 100%;
          }
        }

        .toast {
          margin-bottom: 0.5%;
        }

        #toastwrapper {
          margin-top: 1%;
          margin-right: 1%;
        }
    </style>

    <?php
    // Unblocking function

    if(isset($_GET['unblock'])) {
      unblock();
    }

    function unblock() {
      // Indicate to the user that we are trying to unblock the page

      echo <<<EOL
      <script>
      jQuery(function(){
        $('#requesting-toast').toast('show')
      });
      </script>
EOL;
    }
    ?>
  </head>
  <body>
    <div class="container">
        <div class="alert alert-danger" id="alert" role="alert">
            <h4 class="alert-heading"><i style="margin-right:1%;" class="fas fa-shield-alt"></i>Webpage Blocked</h4>
            <p><?php echo $alertMsg; ?>
            <br />
            <br />
            <strong>Blacklisted URL: </strong><?php if($url_provided) { echo $url; } else { echo "Unknown"; } ?>
            <hr>
            <button onclick='window.location="<?php echo $safeurl; ?>";' type="button" class="btn btn-success btn-lg btn-block">Back to Safety</button>
            <button onclick='window.location="mailto:<?php echo $adminemail; ?>?Subject=Unblock%20Request";' type="button" class="btn btn-primary btn-lg btn-block">Request Permanent Unblock</button>
            <form action="<?php echo $conf['unblock_url']; ?>">
              <input type="hidden" name="url" value="<?php echo $url; ?>">
              <input type="hidden" name="unblock" value="true">
              <button style="margin-top:1%;" type="submit" class="btn btn-warning btn-lg btn-block">Unblock Temporarily</button>
            </form>
            <?php
                    $date = $conf['date'];

                    if($conf['show_tech_info'] == true) {
                      echo <<<EOL
                      <br />
                      <br />
                      <code style="color:gray">TECHNICAL INFO:</code>
                      <br />
                      <code style="color:gray">Reported by $hostname ($server_ip) at $date. Running PiPass version $pipass_v.</code>
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

              $latestVersion = get_data("https://apps.roen.us/pipass/currentversion/");
              
              if($latestVersion != $conf['pipass_v']) {
                echo <<<EOL
                <br />
                <a href="https://github.com/roenw/pipass/releases/" class="badge badge-info">Update Available!</a>
EOL;
              } else {
                echo <<<EOL
                <br />
                <br />
                <code>Your PiPass installation is up-to-date.</code>
EOL;
              }
            ?>
          </div>
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true" id="toastwrapper" style="position: relative; min-height: 200px;">
      <div aria-live="polite" aria-atomic="true">
          <div class="toast" id="requesting-toast" style="position: absolute; top: 0; right: 0;" data-delay="20000">
            <div class="toast-header">
              <strong class="mr-auto">PiPass</strong>
            </div>
            <div class="toast-body">
              Requesting temporary unblock from the server. Do not reload the page, this may take a few seconds.
            </div>
          </div>
        </div>
      <div aria-live="polite" aria-atomic="true">
        <div class="toast" id="success-toast" style="position: absolute; top: 47%; right: 0;" data-delay="20000">
            <div class="toast-header">
              <strong class="mr-auto">PiPass</strong>
            </div>
            <div class="toast-body">
              Success! The page will be unblocked for 2 hours. Please clear your browser's cache to use the website.
            </div>
          </div>
        </div>
      </div>

      <!--- $('#requesting-toast').toast('show') -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>