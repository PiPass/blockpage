<?php
/*
For your PiPass system to function properly, it's reccomended that you
modify all of these variables to appropriate values. An explanation of
each variable is listed as a comment below the variable.

NOTE: All PiPass files are dependent upon this one configuration file. Your 
changes will be widespread!
*/

$conf['show_tech_info'] = true;
// Should usually be set to true, unless you have specific reason to disable
// it. Determines whether the program should show technical info.

$conf['blockpage_url'] = "";
// The URL (not directory) of your blockpage. Setting this incorrectly can
// lead to SSL certificate SAN errors, which prompt the user that the
// connection is "not secure." It's highly reccomended that you change this.
// Example: "https://example.com/blockpage/"

$conf['unblock_url'] = "unblock-exec";
// In most cases this does not have to be changed. Only change it if your
// unblock page resides in a subpath which is not "unblock-exec"

$conf['safeurl'] = "about:home";
// Enter a URL of your choice to go to when a user clicks "back to safety"
// This should not be a directory.

$conf['adminemail'] = "";
// Your email. Used when a user requests a permanent unblock.

$conf['timezone'] = date_default_timezone_set("America/New_York");
// Your timezone. Used when displaying technical info.

$conf['date'] = date('m/d/Y h:i:s a', time());
// Format in which the date/time is presented to end users.

$conf['unblock_seconds'] = 7200;
// How many seconds to unblock a website for when a temporary unblock is
// executed by a user.

$conf['time_friendly'] = "2 hours";
// A way of saying the amount of unblock seconds in english.
// For example, 300 seconds would equal 5 minutes.

$conf['pipass_v'] = "1.3";
// PiPass current version. Must be a NUMBER! Or else "update available" 
// will be showing forever and you will get a HEADACHE trying to debug.
?>
