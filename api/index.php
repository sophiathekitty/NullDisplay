<?php
//echo "hello";
require_once("../../../includes/main.php");
//echo " world";
$settings = new Settings();

$data = PluginAPIs("NullDisplay/");
OutputJson($data);
?>