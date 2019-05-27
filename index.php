<?php
require('config.php');

$url =  "{$_SERVER['HTTP_HOST']}";
$bpLocal = $conf['blockpage_url'];

echo <<<EOL
<form action="$bpLocal" method="get" id="urlpass">
    <input type="hidden" name="url" value="$url">
</form>
<script>
document.getElementById('urlpass').submit();
</script>
EOL;
?>