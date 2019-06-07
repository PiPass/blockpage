<?php
$hostname = gethostname();
$server_ip = $_SERVER['SERVER_ADDR'];
$pipass_v = $conf['pipass_v'];
$date = $conf['date'];
$safeurl = $conf['safeurl'];
$adminemail = $conf['adminemail'];
$unblockLength = date('H:i:s', mktime(0, 0, $conf['unblock_seconds']));

// LOCALE FILE FOR LANGUAGE: "SLOVENIAN"
// ------------------------------------------------

$headerMsg = "Spletna stran blokirana";

$alertMsg = <<<EOL
<p>Ta spletna stran je bila označena kot škodljiva (npr. phishing, škodljiva programska oprema) oziroma kot tehnologija za sledenje po spletu in je bila zato blokirana. Tudi strani oglaševalskih omrežjih in spletnih prevar, so blokirane, zato priporočamo, da se tem stranem izogibate.</p>
<p>Če niste povsem prepričani, da je spletna stran varna priporočamo, da je ne obiščete (izberite možnost "Nazaj na varnost"). Če pa ste mnenja, da je spletna stran varna in je bila blokirana po pomoti, izberite "Začasno omogoči". V primeru, da se težava zaradi blokirane spletne strani pogosto pojavlja, izberite "Zahtevaj trajen dostop".</p>
Funkcija "Začasno omogoči" je avtomatizirana. Spletna stran bo na voljo $unblockLength, nato bo spet blokirana. Lahko se zgodi, da boste morali počistiti vaš DNS predpomnilnik in/ali predpomnilnik vašega brskalnika.
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

$unblockedStatusHeader = "Dostop omogočen";

$unblockedStatus = "Dostop do spletne strani je bil uspešno dodeljen. Spletna stran bo spet blokirana po približno $unblockLength. Po tem lahko znova zahtevate začasen dostop.";

$unblockHelp = "<strong>Če še vedno ne morete dostopati do spletne strani,</strong> poskusite počistiti predpomnilnik vašega brskalnika ali računalnikov DNS predpomnilnik.";
?>
