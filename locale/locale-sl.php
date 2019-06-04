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

$headerMsg = "Spletna stran blokirana";

$alertMsg = <<<EOL
Ta spletna stran je bila označena kot škodljiva (npr. phishing, škodljiva programska oprema) oziroma kot tehnologija za sledenje po spletu in je bila zato blokirana. Tudi strani kot so oglaševalska omrežja in spletne prevare, so najverjetneje blokirane, zato priporočam, da se blokiranim spletnim stranem izogibate.
Če ste mnenja, da je bila ta spletna stran blokirana po pomoti, spodaj izberite "Začasno omogoči". V primeru, da se težava zaradi blokirane spletne strani pogosto pojavlja, spodaj izberite "Zahtevaj trajen dostop".
Funkcija "Začasno omogoči" je avtomatizirana. Spletna stran bo na voljo $unblockLength, nato bo spet blokirana. Po potrebi se lahko zgodi, da boste morali počistiti vaš DNS predpomnilnik in/ali predpomnilnik vašega brskalnika. Sicer, priporočamo, da ne obiščete te spletne strani.
EOL;

$safeButton = "Nazaj na varnost";

$requestUnblockButton = "Zahtevaj trajen dostop";

$unblockTemporaryButton = "Začasno omogoči";

$upToDateMsg = "Imate najnovejšo verzijo PiPass-a.";

$updateAvailMsg = "Na voljo je posodobitev!";

$URLDescriptor = "URL blokirane strani: ";

$technicalInfoHeader = "TEHNIČNI PODATKI:";

$technicalInfoMsg = "Javil $hostname ($server_ip) ob $date. Uporablja PiPass verzijo $pipass_v.";

$bpToastRequestingStatus = "Poteka zahteva za začasen dostop. Ne osvežite strani, to lahko traja nekaj sekund.";

$bpToastSuccessStatus = "Uspeh! Spletna stran bo dostopna $unblockLength. Prosim počistite predpomnilnik brskalnika za dostop do strani.";

$unblockingStatusHeader = "Omogočam dostop";

$unblockingStatus = "Trentno zahtevam začasen dostop do spletne strani. Prosim počakajte, <strong>ne</strong> osvežite strani.";

$unblockedStatusHeader = "Omogočen dostop";

$unblockedStatus = "Dostop do spletne strani je bil uspešno dodeljen. Spletna stran bo spet blokirana po pribljižno $unblockLength. Po tem lahko znova zahtevate začasen dostop.";

$unblockHelp = "<strong>Če še vedno ne morete dostopati do spletne strani,</strong> poskusite počistiti predpomnilnik vašega brskalnika ali računalnikov DNS predpomnilnik.";
?>
