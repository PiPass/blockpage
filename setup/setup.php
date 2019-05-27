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
PiPass v1.2b installer
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
}
?>