<?php
require_once("../../../../includes/main.php");
$data = [];
if(isset($_GET['mac_address'])){
    $data['display'] = DisplayStamps::Stamp(Displays::MacAddress($_GET['mac_address']));
} else {
    $data['displays'] = DisplayStamps::AllDisplays();
}
OutputJson($data);
?>