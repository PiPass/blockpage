<?php
$hostname = gethostname();
$server_ip = $_SERVER['SERVER_ADDR']; 
$date = $conf['date'];
$safeurl = $conf['safeurl'];
$adminemail = $conf['adminemail'];
$unblockLength = date('H:i:s', mktime(0, 0, $conf['unblock_seconds']));
$pipass_version = $conf['pipass_version'];

// LOCALE FILE FOR LANGUAGE: "DUTCH"
// ------------------------------------------------

$headerMsg = "Website geblokkeerd";

$alertMsg = <<<EOL
Deze website is eerder bepaald als een cybersecurity-bedreiging (bijvoorbeeld phishing, malware) of een webtracking-software en is geblokkeerd. Sites zoals advertentienetwerken en oplichting kunnen ook worden geblokkeerd, dus het is in uw beste belang om deze geblokkeerde sites te vermijden.</p>
Als je het gevoel hebt dat deze blokkade ten onrechte is gemaakt, selecteer je hieronder "Blokkade tijdelijk omzeilen". Als de blokkade terugkerende problemen veroorzaakt, selecteert u hieronder "Verzoek permanente deblokkering". 
Het omzeilen van de blokkade is geautomatiseerd. Na $unblockLength wordt de website automatisch weer geblokkeerd. Mogelijk moet u uw DNS-cache wissen of <a href="https://kb.iu.edu/d/ahic">de cache van uw browser</a> wissen.
Anders raden we u aan deze website niet te bezoeken.
EOL;

$safeButton = "Terug naar veiligheid";

$requestUnblockButton = "Verzoek permanente deblokkering";

$unblockTemporaryButton = "Blokkade tijdelijk omzeilen";

$upToDateMsg = "Uw PiPass-installatie is up-to-date.";

$updateAvailMsg = "Update beschikbaar!";

$URLDescriptor = "URL op de blacklist: ";

$technicalInfoHeader = "TECHNISCHE INFO:";

$technicalInfoMsg = "Gerapporteerd door $hostname ($server_ip) op $date. PiPass versie $pipass_version.";

$bpToastRequestingStatus = "Blokkade tijdelijk omzeilen wordt aangevraagd. Laad de pagina niet opnieuw, dit kan enkele seconden duren.";

$bpToastSuccessStatus = "Succes! De pagina wordt $unblockLength gedeblokkeerd. Maak de cache van je browser leeg om de website te gebruiken.";

$unblockingStatusHeader = "Blokkade aan het omzeilen";

$unblockingStatus = "De blokkade wordt op dit moment tijdelijk omzeild. Even geduld, de pagina <strong>niet</strong> verversen";

$unblockedStatusHeader = "Website gedeblokkeerd.";

$unblockedStatus = "De webpagina is succesvol ontgrendeld. De website wordt teruggezet naar geblokkeerd in ongeveer $unblockLength, waarna u mogelijk het deblokkeren opnieuw wilt activeren.";

$unblockHelp = "<strong>Als u de webpagina nog steeds niet kunt bezoeken,</strong> probeert u de DNS-cache van uw computer te wissen, of anders de cache van uw computer te wissen.";
?>
