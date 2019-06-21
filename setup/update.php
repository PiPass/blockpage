<?php
$GLOBALS['document_root'] = null;

echo <<<EOL
\n\n\n\n\n\n\n\n\n\n
######    ######                       
#     # # #     #   ##    ####   ####  
#     # # #     #  #  #  #      #      
######  # ######  #    #  ####   ####  
#       # #       ######      #      # 
#       # #       #    # #    # #    # 
#       # #       #    #  ####   ####  
\n
PiPass updater
\n
EOL;

sleep(5);

echo "[ / ] Root user check...\n";

if (0 == posix_getuid()) {
    echo "[ + ] Root user check complete\n";
    preInstall();
} else {
    echo "[ X ] Root user check failed. Please run the script with sudo.\n";
    exit;
}

function preInstall() {

    echo "[ / ] DR check... Please enter your web document root. (e.g. /var/www/)\n";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line)) {
        $GLOBALS['document_root'] = trim($line);
    }

    
    echo "[ / ] Is this the correct document root? (" .$GLOBALS['document_root'] .") [y/n]\n";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line) != "y") {
        $GLOBALS['document_root'] = trim($line);
        echo "[ - ] DR check failed. Exiting...\n";
    } else {
        if(is_dir($GLOBALS['document_root'])) {
            update();
        } else {
            echo "[ - ] DR check failed. The directory does not exist. Exiting...\n";
            exit;
        }
    }
}

function update() {

    echo "[ / ] Your configuration file will be backed up, but other than that:\n";
    echo "[ / ] BY UPDATING, YOUR CONFIGURATION FILES, EVEN IF STASHED OR COMMITTED, WILL BE OVERWRITTEN. CONTINUE? [y/n]\n";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line) != "y") {
        echo "[ - ] Aborted by user.\n";
        exit;
    }

    echo "[ + ] Backed up your config file. \n";
    echo "[ + ] DR check succeeded, now updating PiPass... \n";
    echo "[ + ] In document root... backing up config file.\n";
    $drf_local = $GLOBALS['document_root'];
    exec("cd $drf_local && sudo mv config.php config.php.bak");
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
    exec("cd $drf_local && git describe --exact-match --tags $(git log -n1 --pretty='%h')", $output);
    if("v".$latestVersion === $output[0]) {
        echo "[ / ] Aborted by PiPass updater: You are already on the latest version of PiPass, version $output[0].\n";
        exit;
    } else {
        $oldVersion = $output[0];
        echo "Updating from $oldVersion to v$latestVersion.";
    }
    echo "[ + ] Collecting files for latest version v$latestVersion.\n";
    exec("cd $drf_local && sudo git fetch --all");
    exec("cd $drf_local && git reset --hard v$latestVersion");
    echo "[ + ] Selected version v$latestVersion\n";
    echo "[ + ] Update success. You are now running PiPass v$latestVersion.\n";
    echo "[ + ] Update complete.\n";
    echo "[ + ] NOTE: Make sure you fill out config.php or you will get stuck in a redirect loop! You might want to merge config.php and the backup I created, config.php.bak.\n";
}
?>
