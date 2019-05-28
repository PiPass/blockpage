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
PiPass installer
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
            install();
        } else {
            echo "[ - ] DR check failed. The directory does not exist. Exiting...\n";
            exit;
        }
    }
}

function install() {
    echo "[ + ] DR check succeeded, now installing PiPass... \n";
    echo "[ / ] Getting current php user...\n";
    $GLOBALS['phpuser'] = exec('php getuser.php');
    $localPU = $GLOBALS['phpuser'];
    echo "[ + ] Current php user is " .$GLOBALS['phpuser'] .".\n";
    echo "[ / ] Building /etc/sudoers line to add...\n";
    $sudoersline = "$localPU ALL=(ALL) NOPASSWD: /usr/local/bin/pihole -w *, /usr/local/bin/pihole -w -d *";
    echo "[ / ] Checking if /etc/sudoers is already set up...\n";
    $sudoersRes = exec("sudo cat /etc/sudoers | grep /usr/local/bin/pihole");
    if(empty($sudoersRes)) {
        echo "[ / ] Adding line to /etc/sudoers...\n";
        exec("echo '$sudoersline' | sudo tee -a /etc/sudoers");
        echo "[ + ] Permissions have been set up successfully!\n";
    } else {
        echo "[ / ] /etc/sudoers is already set up... not performing action.\n";
    }
    echo "[ / ] Now making sure that your document root folder is clear...\n";
    $drf_local = $GLOBALS['document_root'];
    $drfiles = exec("ls $drf_local | grep index");
    if(!empty($drfiles)) {
        echo "[ - ] It looks like there are index files in your webroot. Such as index.php, index.html, etc. Please remove them or change their name to continue installation.\n";
        exit;
    }

    $drfiles = exec("ls $drf_local | grep pipass");
    if(!empty($drfiles)) {
        echo "[ - ] It looks like there are already pipass files in your webroot. (files containing 'pipass' in name trigger this warning)\n";
        exit;
    }

    $drfiles = exec("ls $drf_local | grep setup");
    if(!empty($drfiles)) {
        echo "[ - ] It looks like there are already setup files in your webroot. (files containing 'setup' in the name trigger this warning)\n";
        exit;
    }

    echo "[ + ] In document root... downloading files.\n";
    exec("cd $drf_local && sudo git init .");
    exec("cd $drf_local && sudo git remote add -t \* -f origin https://github.com/roenw/pipass.git");
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
    echo "[ + ] Files downloaded. Selecting version v$latestVersion\n";
    exec("cd $drf_local && sudo git checkout tags/v$latestVersion");
    echo "[ + ] Selected version v$latestVersion\n";
    echo "[ + ] Installation complete. Please set your webserver to redirect all 404 pages to the homepage (web root). This function is not automated yet.\n";
    echo "[ + ] NOTE: Make sure you fill out config.php or you will get stuck in a redirect loop!\n";
}
?>