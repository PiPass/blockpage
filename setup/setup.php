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

echo "Root user check...\n";

if (0 == posix_getuid()) {
    echo "Root user check complete\n";
    preInstall();
} else {
    echo "\033[01;31m\n FATAL: Root user check failed. Please run the script again with sudo.\033[0m\n";
    exit;
}

function preInstall() {
    exec("sudo rm setup.php.*");
    $cfm = __FILE__;
    exec("sudo mv $cfm setup.php");
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
            install();
        } else {
            echo "\033[01;31m\n FATAL: The directory does not exist. Exiting...\033[0m\n";
            exit;
        }
    }
}

function install() {
    echo "DR check succeeded, now installing PiPass... \n";
    $GLOBALS['phpuser'] = get_current_user();
    $localPU = $GLOBALS['phpuser'];
    echo "Current php user is " .$GLOBALS['phpuser'] .".\n";
    echo "Building /etc/sudoers line to add...\n";
    $sudoersline = "$localPU ALL=(ALL) NOPASSWD: /usr/local/bin/pihole -w *, /usr/local/bin/pihole -w -d *";
    echo "Checking if /etc/sudoers is already set up...\n";
    $sudoersRes = exec("sudo cat /etc/sudoers | grep /usr/local/bin/pihole");
    if(empty($sudoersRes)) {
        echo "Adding line to /etc/sudoers...\n";
        exec("echo '$sudoersline' | sudo tee -a /etc/sudoers");
        echo "Permissions have been set up successfully!\n";
    } else {
        echo "/etc/sudoers is already set up. No need to add another line.\n";
    }

    $drf_local = $GLOBALS['document_root'];
    $drfiles = exec("ls $drf_local | grep -E 'index.html|index.php'");
    if(!empty($drfiles)) {
        echo "\033[01;31m\n FATAL: There are index files in the webroot your specified, such as index.php or index.html. To avoid overwriting them, the PiPass installer has exited. Please remove them or rename them and return to the installation script. \033[0m\n";
        exit;
    }

    echo "Setting up Git repository and collecting PiPass files.\n";
    exec("cd $drf_local && sudo git init .");
    exec("cd $drf_local && sudo git remote add -t \* -f origin https://github.com/roenw/pipass.git");
    exec("sudo git pull origin master");
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
    echo "Files downloaded. Moving to latest stable release v$latestVersion\n";
    exec("cd $drf_local && sudo git checkout tags/v$latestVersion");
    if ( file_exists('/etc/lighttpd/lighttpd.conf') == true ) {
		echo "Lighttpd web server detected. Modifying 404 redirects.\n";
		if (!file_exists('/etc/lighttpd/lighttpd.conf.pipass.bak')) {
			echo "No lighttpd.conf backup found for PiPass. Backing up before modifying.\n";
			exec("sudo cp /etc/lighttpd/lighttpd.conf /etc/lighttpd/lighttpd.conf.pipass.bak");
		}
		exec('sudo sed -i /etc/lighttpd/lighttpd.conf -re \'s/(server.error-handler-404[^"]*")([^"]*)(")/\1index\.php\3/\'');
	} else {
        echo "\033[01;33m\n WARN: Didn't detect lighttpd webserver and was unable to modify 404 settings. Please manually set 404s to redirect to the webroot. \033[0m\n";
	}
	if (file_exists('/etc/pihole/pihole-FTL.conf')) {
		echo "Modifying PiHole FTL to BLOCKINGMODE=IP\n";
		if (!file_exists('/etc/pihole/pihole-FTL.conf.pipass.bak')) {
			echo "No pihole-FTL.conf backup found for PiPass. Backing up before modifying.\n";
			exec("sudo cp /etc/pihole/pihole-FTL.conf /etc/pihole/pihole-FTL.conf.pipass.bak");
		}
		exec('sudo sed -i \'/^BLOCKINGMODE=/{h;s/=.*/=IP/};${x;/^$/{s//BLOCKINGMODE=IP/;H};x}\' /etc/pihole/pihole-FTL.conf');
	} else {
        echo "\033[01;33m\n WARN: Unable to detect pihole-FTL.conf. Do you have Pi-Hole installed? \033[0m\n";
	}
    echo "Selected version v$latestVersion\n";

    exec("cd $drf_local && sudo rm -r .github README.md setup docs mkdocs.yml");
    echo "Removed redundant files.";

    echo "\033[01;32m\n Installation complete. \033[0m\n";
}
?>
