<?php
if(file_exists('../config.php')) {
    require('../../config.php');
} else {
    require('../../config-sample.php');
    echo "WARNING: Currently using the sample configuration file. Please make a local copy called config.php to clear this warning.";
}
$usrLanguage = $conf['language'];
require("../../locale/locale-$usrLanguage.php");

$GLOBALS['unblockTimeSec'] = $conf['unblock_seconds'];

if(isset($_GET['url'])) {
    if(strpos($_GET['url'], ':') !== false) {
        // Strip port out of DNS name since PiHole does not deal with ports
        $url = substr($_GET['url'], 0, strpos($_GET['url'], ":"));

        // After stripping out port, then we sanitize/escape the input before doing anything with it
        $url = htmlentities($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Set global URL variable
        $GLOBALS['url'] = $url;
    } else {
        // There is no port number so we go straight to sanitizing the user input
        $url = htmlentities($_GET['url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Set global URL variable
        $GLOBALS['url'] = $url;
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
  <script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

        #alert {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 95%;
        }
    </style>
  </head>
  <body>
    <div class="container">
    <?php
      if($_GET['unblock'] != "unblocked") {
        echo <<<EOL
        <div class="alert alert-warning" id="alert" role="alert">
        <h4 class="alert-heading"><i style="margin-right:1%;" class="fas fa-shield-alt"></i>$unblockingStatusHeader</h4>
        <p>$unblockingStatus</p>
        <br />
        <br />
        <strong>$URLDescriptor </strong>$url
        <hr>
        <form id="interstitialUnblock" method="GET">
        <input type="hidden" name="unblockurl" value="$url">
        <input type="hidden" name="url" value="$url">
        <input type="hidden" name="unblock" value="unblocked">
EOL;
        
        if(isset($_GET['unblock']) || !($url_provided)) {
          echo <<<EOL
            <button type="submit" style="display:none;" class="btn btn-warning btn-lg btn-block">$unblockTemporaryButton</button>
            </form>
          </div>
EOL;
        } else {
          echo <<<EOL
            <button type="submit" style="display:none;" class="btn btn-warning btn-lg btn-block">$unblockTemporaryButton</button>
            </form>
          </div>
EOL;
        }
      } else {
        echo <<<EOL
        <div class="alert alert-info" id="alert" role="alert">
        <h4 class="alert-heading"><i style="margin-right:1%;" class="fas fa-check"></i>$unblockedStatusHeader</h4>
        <p>$unblockedStatus</p>
        <br />
        $unblockHelp
EOL;
        if($conf['show_tech_info'] == true) {
          echo <<<EOL
          <br />
          <br />
          <code style="color:gray">$technicalInfoHeader</code>
          <br />
          <code style="color:gray">$technicalInfoMsg</code>
          </div>
EOL;
        } else {
          echo <<<EOL
          </div>
EOL;
        }
      }
    ?>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    // Unblocking function

    if($_GET['unblock'] == "unblocked") {
      unblock();
    } else if($_GET['unblock'] == "true") {
      sleep(1);
      echo <<<EOL
      <script>
      setTimeout(function() {document.getElementById('interstitialUnblock').submit();}, 5000);
      </script>
EOL;
    }
    function unblock() {

      // Build command to add to P-H whitelist
      // $addWhitelistComm = "pihole -w " .$GLOBALS['url'];
      $addWhitelistComm = "sudo pihole -w ".$GLOBALS['url']." > /dev/null &";


      // Build command to schedule removal from P-H whitelist. Sleep x = sleep for x number of seconds. 300 = 5 minutes.
      $rmWhitelistComm = "( sleep ".$GLOBALS['unblockTimeSec']."; sudo pihole -w -d ".$GLOBALS['url']." & ) > /dev/null &";

      // Execute P-H whitelist add command
      exec($addWhitelistComm);

      // Execute command that schedules removal of domain from P-H whitelist
      exec($rmWhitelistComm);

      // All done!
    }
?>