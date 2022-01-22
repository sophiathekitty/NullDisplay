<?php
require_once("../../../../../includes/main.php");
$data = [];

$data['display'] = Displays::MacAddress(LocalMac());
OutputJson($data);
?>