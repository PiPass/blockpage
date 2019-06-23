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

echo "Root user check...\n";

if (0 == posix_getuid()) {
    echo "Root user check complete\n";
    preInstall();
} else {
    echo "\033[01;31m\n FATAL: Root user check failed. Please run the script again with sudo.\033[0m\n";
    exit;
}

function preInstall() {

    echo "Please enter your web document root. (e.g. /var/www/html)\n";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line)) {
        $GLOBALS['document_root'] = trim($line);
    }

    
    echo "Confirmation: Is this the correct document root? (" .$GLOBALS['document_root'] .") [y/n]\n";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line) != "y") {
        $GLOBALS['document_root'] = trim($line);
        echo "\033[01;33m\n WARN: User aborted. Exiting... \033[0m\n";
    } else {
        if(is_dir($GLOBALS['document_root'])) {
            if(is_dir($GLOBALS['document_root']."/blockpage")) {
                update();
            } else {
                echo "\033[01;31m\n FATAL: Unable to detect your PiPass installation. Is it corrupt?\033[0m\n";
            }
        } else {
            echo "\033[01;31m\n FATAL: The directory does not exist. Exiting...\033[0m\n";
            exit;
        }
    }
}

function update() {


    echo "DR check succeeded, now updating PiPass... \n";
    $drf_local = $GLOBALS['document_root'];
    exec("cd $drf_local && sudo cp config.php config.php.bak > /dev/null 2>&1 &");

    echo "Attempted to back up your config file. \n";

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

    echo "Collecting files for latest version v$latestVersion.\n";
    exec("cd $drf_local && sudo git fetch origin");
    echo "Configuring local git profile";
    exec('git config user.email "pipass@example.com"');
    exec('git config user.name "PiPass User"');
    exec("cd $drf_local && sudo git fetch https://github.com/roenw/PiPass tags/v1.3");
    echo "Merging local changes with latest version (using git merge) \n";
    exec("cd $drf_local && sudo git merge origin/master");
    echo "Merged local changes.\n";
    echo "\033[01;32m\n Update successful! You are now running PiPass v$latestVersion.\033[0m\n";
}
?>
