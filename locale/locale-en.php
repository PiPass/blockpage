<?php
$hostname = gethostname();
$server_ip = $_SERVER['SERVER_ADDR']; 
$pipass_v = $conf['pipass_v'];
$date = $conf['date'];
$safeurl = $conf['safeurl'];
$adminemail = $conf['adminemail'];
$unblockLength = date('H:i:s', mktime(0, 0, $conf['unblock_seconds']));

// LOCALE FILE FOR LANGUAGE: "ENGLISH"
// ------------------------------------------------

$headerMsg = "Webpage Blocked";

$alertMsg = <<<EOL
This website has been previously determined as a cybersecurity threat (e.g. phishing, malware) or a web tracking software and has been blocked. Sites such as advertising networks and scams may also be blocked, so it's in your best interest to avoid these blocked sites.</p>
If you feel like this block has been made in error, select "Bypass Temporarily" below. If the block is causing recurring problems, select "Request Permanent Unblock" below. 
The bypass temporarily function is automated. The unblock will last for $unblockLength, then revert to blocked. You may need to flush your DNS cache and/or <a href="https://kb.iu.edu/d/ahic">your browser's cache.</a>
Otherwise, we suggest you do not visit this website.
EOL;

$safeButton = "Back to Safety";

$requestUnblockButton = "Request Permanent Unblock";

$unblockTemporaryButton = "Unblock Temporarily";

$upToDateMsg = "Your PiPass installation is up-to-date.";

$updateAvailMsg = "Update Available!";

$URLDescriptor = "Blacklisted URL: ";

$technicalInfoHeader = "TECHNICAL INFO:";

$technicalInfoMsg = "Reported by $hostname ($server_ip) at $date. Running PiPass version $pipass_v.";

$bpToastRequestingStatus = "Requesting temporary unblock from the server. Do not reload the page, this may take a few seconds.";

$bpToastSuccessStatus = "Success! The page will be unblocked for 2 hours. Please clear your browser's cache to use the website.";
?>