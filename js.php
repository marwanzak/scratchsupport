<?php
header("Content-Type: text/javascript");
require("./include/site_config.php");
echo "var base_url = '$base_url';\n";
echo "var ipaddress = '".$_SERVER['REMOTE_ADDR']."';\n";