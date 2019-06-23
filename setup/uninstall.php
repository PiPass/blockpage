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
PiPass uninstaller
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
            uninstall();
        } else {
            echo "\033[01;31m\n FATAL: The directory does not exist. Exiting...\033[0m\n";
            exit;
        }
    }
}

function uninstall() {
    echo "You are about to fully remove PiPass and its integration from your system. Are you sure you want to continue? [y/n]";

    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line) != "y") {
        echo "\033[01;33m\n WARN: User aborted. Exiting... \033[0m\n";
        exit;
    }

    $drf_local = $GLOBALS['document_root'];

    $GLOBALS['phpuser'] = get_current_user();
    $localPU = $GLOBALS['phpuser'];
    $sudoersline = preg_quote("$localPU ALL=(ALL) NOPASSWD: /usr/local/bin/pihole -w *, /usr/local/bin/pihole -w -d *", '/,');

    echo "Removing PiPass entry from /etc/suoders\n";
    exec("sudo sed -ri '/$sudoersline/d' /etc/sudoers");

    if (file_exists("$drf_local/blockpage")) {
        echo "Removing PiPass files...\n";
        exec("cd $drf_local && sudo rm -rf index.php config.php README.md setup blockpage .git");
    }
    if (file_exists('/etc/lighttpd/lighttpd.conf.pipass.bak')) {
        echo "Restoring backup of lighttpd.conf\n";
        exec("sudo mv /etc/lighttpd/lighttpd.conf.pipass.bak /etc/lighttpd/lighttpd.conf");
    }
    if (file_exists('/etc/pihole/pihole-FTL.conf.pipass.bak')) {
    echo "Restoring backup of pihole-FTL.conf\n";
    exec("sudo mv /etc/pihole/pihole-FTL.conf.pipass.bak /etc/pihole/pihole-FTL.conf");
    }

    if (file_exists('/etc/lighttpd/lighttpd.conf.pipass.bak')) {
        echo "Restoring backup of lighttpd.conf\n";
        exec("sudo mv /etc/lighttpd/lighttpd.conf.pipass.bak /etc/lighttpd/lighttpd.conf");
    }
    if (file_exists('/etc/pihole/pihole-FTL.conf.pipass.bak')) {
        echo "Restoring backup of pihole-FTL.conf\n";
        exec("sudo mv /etc/pihole/pihole-FTL.conf.pipass.bak /etc/pihole/pihole-FTL.conf");
    }

    echo "\033[01;32m\nPiPass has been completely removed from your system.\033[0m\n";
    echo "\nIf you don't mind, please tell us what made you uninstall by creating a new issue on our GitHub, roenw/PiPass.\n";
}
?>
