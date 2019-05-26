<?php
// VARIABLES TO CHANGE
$blockpage_url = ""; // The URL of your blockpage. Example: "https://192.168.2.3/blockpage/"

// There is no need to change variables below this line.
// --------------------------
$url =  "{$_SERVER['HTTP_HOST']}";
echo <<<EOL
<form action="$blockpage_url" method="post" id="urlpass">
    <input type="hidden" name="url" value="$url">
</form>
<script>
document.getElementById('urlpass').submit();
</script>
EOL;
?>