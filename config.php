<?php
/*
For your PiPass system to function properly, it's reccomended that you
modify all of these variables to appropriate values. An explanation of
each variable is listed as a comment below the variable.

NOTE: All PiPass files are dependent upon this one configuration file. Your 
changes will be widespread!
*/

$ini_path = "{$_SERVER['HOME']}/.config/PiPass/PiPass.ini";
$ini = [];

// If the ini file exists, use it. If not, create an empty $ini array so
// checks against it fail.

if (file_exists($ini_path)) {
  $ini = parse_ini_file($ini_path);
}

function get_config($section, $defaultValue) {
  global $ini;
  if (array_key_exists($section , $ini) == true) {
    return $ini[$section];
  } else {
    return $defaultValue;
  }
}

function get_language() {
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $files = array_values(array_diff(scandir('locale'), array('..', '.')));
    $translations = array();
    
    for ($i = 0; $i < count($files); $i++) {
		$str = "$files[$i]";
		if (preg_match('/locale-([a-z][a-z]).php/', $str, $match) == 1) {
			$translations[] = $match[1];
		}
	}
	$lang = in_array($lang, $translations) ? $lang : $conf['language'];
	return $lang;
}

$conf["language"] = get_config('language', "en");
// Default/fallback language to use in PiPass. Should be in IEFT language format.

$conf['show_tech_info'] = get_config('show_tech_info', true);
// Should usually be set to true, unless you have specific reason to disable
// it. Determines whether the program should show technical info.

$conf['blockpage_url'] = get_config('blockpage_url', "index.php");
// The URL (not directory) of your blockpage. Setting this incorrectly can
// lead to SSL certificate SAN errors, which prompt the user that the
// connection is "not secure." It's highly reccomended that you change this.
// Example: "https://example.com/blockpage/"

$conf['unblock_url'] = get_config('unblock-url', "unblock-exec");
// In most cases this does not have to be changed. Only change it if your
// unblock page resides in a subpath which is not "unblock-exec"

$conf['safeurl'] = get_config('safeurl', "about:home");
// Enter a URL of your choice to go to when a user clicks "back to safety"
// This should not be a directory.

$conf['adminemail'] = get_config('adminemail', "");
// Your email. Used when a user requests a permanent unblock.

$conf['timezone'] = date_default_timezone_set(get_config('timezone', "America/New_York"));
// Your timezone. Used when displaying technical info.

$conf['date'] = date(get_config('date', 'm/d/Y h:i:s a'), time());
// Format in which the date/time is presented to end users.

$conf['unblock_seconds'] = get_config('unblock_seconds', 7200);
// How many seconds to unblock a website for when a temporary unblock is
// executed by a user.

$conf['pipass_v'] = "1.3";
// PiPass current version. Must be a NUMBER! Or else "update available" 
// will be showing forever and you will get a HEADACHE trying to debug.
?>
