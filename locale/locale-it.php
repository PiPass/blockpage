<?php
require('../version.php');

$hostname = gethostname();
$server_ip = $_SERVER['SERVER_ADDR'];
$date = $conf['date'];
$safeurl = $conf['safeurl'];
$adminemail = $conf['adminemail'];
$unblockLength = date('H:i:s', mktime(0, 0, $conf['unblock_seconds']));

// LOCALE FILE FOR LANGUAGE: "ITALIANO"
// ------------------------------------------------

$headerMsg = "Pagina web bloccata";

$alertMsg = <<<EOL
Questo sito web &egrave; riconosciuto come possibile minaccia (per esempio phishing o malware) o veicolo di tracciamento delle tue abitudini ed &egrave; stato quindi bloccato. Siti web contenenti pubblicit&agrave; indesiderate e truffe vengono bloccati alla stessa maniera, &egrave; nel tuo interesse non visitarli se non strettamente necessario.</p>
Se hai comunque necessit&agrave; di accedere alla pagina web puoi fare clic sul pulsante "Sblocca temporaneamente". Se credi di aver bisogno nuovamente di visitare lo stesso sito web in futuro seleziona invece "Richiedi sblocco permanente" qui di seguito.
La funzione di sblocco temporaneo &egrave; automatica, il sito web verr&agrave; sbloccato per $unblockLength, quindi nuovamente bloccato successivamente. Potresti dover cancellare la cache DNS e/o <a href="https://kb.iu.edu/d/ahic">quella del tuo browser</a> per proseguire.
In ogni caso ti suggerisco di non visitare questo sito web al quale hai tentato di accedere.
EOL;

$safeButton = "Abbandona il sito web";

$requestUnblockButton = "Richiedi sblocco permanente";

$unblockTemporaryButton = "Sblocca temporaneamente";

$upToDateMsg = "La versione di PiPass &egrave; aggiornata.";

$updateAvailMsg = "&Egrave; disponibile un aggiornamento";

$URLDescriptor = "URL bloccato: ";

$technicalInfoHeader = "INFORMAZIONI TECNICHE:";

$technicalInfoMsg = "Segnalato da $hostname ($server_ip) il $date. La versione di PiPass in uso &egrave; la $version.";

$bpToastRequestingStatus = "Requesting temporary unblock from the server. Do not reload the page, this may take a few seconds.";

$bpToastSuccessStatus = "Fatto. La pagina web &egrave; stata sbloccata per 2 ore. Per cortesia cancella la cache del tuo browser per poter accedere al sito web richiesto.";

$unblockingStatusHeader = "Sblocco la pagina web";

$unblockingStatus = "Sto sbloccando temporaneamente la pagina web che hai richiesto. Per cortesia attendi e <strong>NON</strong> aggiornare la pagina.";

$unblockedStatusHeader = "Pagina web sbloccata";

$unblockedStatus = "La pagina web &egrave; stata sbloccata. Il sito web torner&agrave; a essere bloccato all'incirca in $unblockLength, dopodich&eacute; dovrai richiederne nuovamente lo sblocco se necessario.";

$unblockHelp = "<strong>Se non riesci ancora a visitare la pagina web che hai richiesto</strong>, prova a pulire la cache DNS o quella del tuo browser.";
?>
