<?php
require('common/config.php');

$url =  "{$_SERVER['HTTP_HOST']}";
$bpLocal = $conf['blockpage_url'];

if(empty($conf['blockpage_url'])) {
    die("blockpage_url cannot be blank. Check config.php.");
}

echo <<<EOL
<form action="$bpLocal" method="get" id="urlpass">
    <input type="hidden" name="url" value="$url">
</form>
<script>
document.getElementById('urlpass').submit();
</script>
EOL;
?>