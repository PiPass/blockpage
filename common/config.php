<?php
/*
Please do NOT modify this file unless you are trying to tweak something and you
KNOW WHAT YOU'RE DOING! This file is critical to PiPass and incorrectly modifying it
can break your installation.

You have been warned.
*/

error_reporting(E_ALL);
ini_set('display_errors',1);

$dbLocation = "/opt/pipass/cfg.db";
$GLOBALS["dbLocation"] = $dbLocation;

if(!is_file($dbLocation)) {
  die("Uncatchable fatal error caused application to exit: Unable to open connection to the database at $cfgDbLocation. Does it exist? Do I have permission to read and modify it?");
}

function get_config($section) {
  $sqlite = new PDO("sqlite:".$GLOBALS["dbLocation"]);
  $config = $sqlite->query("SELECT * FROM data WHERE field = '$section'");
  $cfgAll = $config->fetchAll();

  $currentValue = $cfgAll[0][1];
  return $currentValue;
}

$conf["language"] = get_config('language');
// Language to use in PiPass. Should be in IEFT language format.

$conf['show_tech_info'] = get_config('show_tech_info');
// Should usually be set to true, unless you have specific reason to disable
// it. Determines whether the program should show technical info.

$conf['blockpage_url'] = get_config('blockpage_url');
// The URL (not directory) of your blockpage. Setting this incorrectly can
// lead to SSL certificate SAN errors, which prompt the user that the
// connection is "not secure." It's highly reccomended that you change this.
// Example: "https://example.com/blockpage/"

$conf['unblock_url'] = get_config('unblock-url');
// In most cases this does not have to be changed. Only change it if your
// unblock page resides in a subpath which is not "unblock-exec"

$conf['safeurl'] = get_config('safeurl');
// Enter a URL of your choice to go to when a user clicks "back to safety"
// This should not be a directory.

$conf['adminemail'] = get_config('adminemail');
// Your email. Used when a user requests a permanent unblock.

$conf['timezone'] = date_default_timezone_set(get_config('timezone'));
// Your timezone. Used when displaying technical info.

$conf['date'] = date(get_config('date'), time());
// Format in which the date/time is presented to end users.

$conf['unblock_seconds'] = get_config('unblock_seconds');
// How many seconds to unblock a website for when a temporary unblock is
// executed by a user.

$conf['pipass_v'] = "1.3";
// PiPass current version. Must be a NUMBER! Or else "update available" 
// will be showing forever and you will get a HEADACHE trying to debug.
?>
