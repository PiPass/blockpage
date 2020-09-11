<?php
require('../version.php');

$hostname = gethostname();
$server_ip = $_SERVER['SERVER_ADDR']; 
$date = $conf['date'];
$safeurl = $conf['safeurl'];
$adminemail = $conf['adminemail'];
$unblockLength = date('H:i:s', mktime(0, 0, $conf['unblock_seconds']));

// GEBIETSSCHEMA FÜR FOLGENDE SPRACHE: "DEUTSCH"
// ------------------------------------------------

$headerMsg = "Webpage Blocked";

$alertMsg = <<<EOL
Diese Webseite wurde kürzlich als Cybersecurity Risiko (e.g. phishing, malware) oder als tracking Software eingestuft und wurde gesperrt. Werbenetzwerke oder Betrugsseiten werden unter Umständen ebenfalls gesperrt, daher ist es in Ihrem interesse diese gesperrten Seiten zu meiden.</p>
Wenn Sie der Meinung sind, dass diese Sperre versehentlich eingerichtet wurde, wählen Sie unten "Temporäre Freigabe". Wenn die Sperre Ihnen wiederkehrend Probleme verursacht, wählen Sie unten "Dauherhafte Freigabe anfordern".
Die temporäre Freigabe ist automatisiert. The Freigabe erfolgt für $unblockLength und anschließend wird die Sperre wieder hergestellt. Unter Umständen müssen Sie den DNS Cache leeren und/oder den <a href="https://kb.iu.edu/d/ahic">Cache ihres Browsers.</a>
Andernfalls empfehlen wir, diese Webseite nicht zu besuchen.
EOL;

$safeButton = "Zurück in die Sicherheit";

$requestUnblockButton = "Dauerhafte Freigabe anfordern";

$unblockTemporaryButton = "Temporäre Freigabe";

$upToDateMsg = "Ihre PiPass Installation is aktuell.";

$updateAvailMsg = "Aktualisierung verfügbar!";

$URLDescriptor = "Gesperrte URL: ";

$technicalInfoHeader = "TECHNISCHE INFO:";

$technicalInfoMsg = "Berichtet von $hostname ($server_ip) am $date. Laufende PiPass Version $version.";

$bpToastRequestingStatus = "Fordere temporäre Freigabe vom Server an. Bitte laden Sie die Seite nicht neu, es könnte einige Sekunden dauern.";

$bpToastSuccessStatus = "Erfolgreich! Die Seite wird für $unblockLength freigegeben. Bitte leeren Sie Ihren Browser Cache um die Webseite zu besuchen.";

$unblockingStatusHeader = "Entsperre Webseite";

$unblockingStatus = "Entsperre aktuell die angeforderte Seite vorübergehend. Bitte warten, laden Sie die Seite <strong>nicht</strong> neu.";

$unblockedStatusHeader = "Webseite freigegeben";

$unblockedStatus = "Die Webseite wurde erfolgreich freigegeben. Die Webseite wird in ungefär $unblockLength wieder gesperrt, nach welcher Sie eine erneute Freigabe starten können.";

$unblockHelp = "<strong>Wenn Sie die Webseite immer noch nicht aufrufen können,</strong> versuchen Sie den DNS Cache Ihres Computers oder Ihres Browser zu leeren.";
?>
