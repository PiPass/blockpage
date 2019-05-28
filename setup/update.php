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
    echo "[ + ] Backed up your config file. \n";
    echo "[ + ] DR check succeeded, now updating PiPass... \n";
    echo "[ + ] In document root... backing up config file.\n";
    $drf_local = $GLOBALS['document_root'];
    exec("cd $drf_local && sudo mv config.php config.php.bak");
    echo "[ + ] Collecting files...\n";
    exec("cd $drf_local && sudo rm -r blockpage pipass && sudo rm index.php");
    exec("cd $drf_local && sudo git clone https://github.com/roenw/pipass.git/");
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
    echo "[ + ] Files downloaded. Selecting latest version v$latestVersion.\n";
    exec("cd $drf_local/pipass && sudo git checkout tags/v$latestVersion");
    echo "[ + ] Selected version v$latestVersion\n";
    echo "[ + ] Moving all files up a directory...\n";
    exec("cd $drf_local && sudo mv pipass/* .");
    echo "[ + ] Success.\n";
    echo "[ + ] Update complete.\n";
    echo "[ + ] NOTE: Make sure you fill out config.php or you will get stuck in a redirect loop!\n";
}
?>