<?php
echo "[ + ] Commencing uninstallation of PiPass.";
$GLOBALS['phpuser'] = get_current_user();
$localPU = $GLOBALS['phpuser'];
$sudoersline = preg_quote("$localPU ALL=(ALL) NOPASSWD: /usr/local/bin/pihole -w *, /usr/local/bin/pihole -w -d *", '/,');
echo "[ + ] Removing PiPass entry from /etc/suoders\n";
exec("sudo sed -ri '/$sudoersline/d' /etc/sudoers");

if (file_exists('/var/www/html/blockpage')) {
echo "[ + ] Removing PiPass files...\n";
exec("cd /var/www/html && sudo rm -rf index.php config.php README.md setup blockpage .git");
}
if (file_exists('/etc/lighttpd/lighttpd.conf.pipass.bak')) {
echo "[ + ] Restoring backup of lighttpd.conf\n";
exec("sudo mv /etc/lighttpd/lighttpd.conf.pipass.bak /etc/lighttpd/lighttpd.conf");
}
if (file_exists('/etc/pihole/pihole-FTL.conf.pipass.bak')) {
echo "[ + ] Restoring backup of pihole-FTL.conf\n";
exec("sudo mv /etc/pihole/pihole-FTL.conf.pipass.bak /etc/pihole/pihole-FTL.conf");
}

if (file_exists('/var/www/blockpage')) {
echo "[ + ] Removing PiPass files...\n";
exec("cd /var/www/ && sudo rm -rf index.php config.php README.md setup blockpage .git");
}
if (file_exists('/etc/lighttpd/lighttpd.conf.pipass.bak')) {
echo "[ + ] Restoring backup of lighttpd.conf\n";
exec("sudo mv /etc/lighttpd/lighttpd.conf.pipass.bak /etc/lighttpd/lighttpd.conf");
}
if (file_exists('/etc/pihole/pihole-FTL.conf.pipass.bak')) {
echo "[ + ] Restoring backup of pihole-FTL.conf\n";
exec("sudo mv /etc/pihole/pihole-FTL.conf.pipass.bak /etc/pihole/pihole-FTL.conf");
}
echo "[ + ] PiPass has been fully uninstalled and all files have been cleaned up and removed.\n";
echo "[ / ] If you don't mind, please tell us what made you uninstall by creating a new issue on our GitHub, roenw/PiPass.\n";
?>
