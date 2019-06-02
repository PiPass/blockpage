<?php
echo "[ + ] Commencing uninstallation of PiPass.";
echo "[ + ] We're sad to see you go... please help improve this project by leaving feedback on what issues casued you to leave.";
$GLOBALS['phpuser'] = get_current_user();
$localPU = $GLOBALS['phpuser'];
$sudoersline = preg_quote("$localPU ALL=(ALL) NOPASSWD: /usr/local/bin/pihole -w *, /usr/local/bin/pihole -w -d *", '/,');
echo "[ + ] Removing PiPass entry from /etc/suoders";
exec("sudo sed -ri '/$sudoersline/d' /etc/sudoers");

if (file_exists('/var/www/html/blockpage')) {
echo "[ + ] Removing PiPass files...";
exec("cd /var/www/html && sudo rm -rf index.php config.php README.md setup blockpage .git");
}
if (file_exists('/etc/lighttpd/lighttpd.conf.pipass.bak')) {
echo "[ + ] Restoring backup of lighttpd.conf";
exec("sudo mv /etc/lighttpd/lighttpd.conf.pipass.bak /etc/lighttpd/lighttpd.conf");
}
if (file_exists('/etc/pihole/pihole-FTL.conf.pipass.bak')) {
echo "[ + ] Restoring backup of pihole-FTL.conf";
exec("sudo mv /etc/pihole/pihole-FTL.conf.pipass.bak /etc/pihole/pihole-FTL.conf");
}
echo "[ + ] PiPass has been uninstalled."
?>
