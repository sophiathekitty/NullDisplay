<?php
require_once("../../../../includes/main.php");
$data = [];
if(isset($_GET['mac_address'])){
    $data['display'] = Displays::MacAddress($_GET['mac_address']);
} else {
    $data['displays'] = Displays::AllDisplays();
}
OutputJson($data);
?>