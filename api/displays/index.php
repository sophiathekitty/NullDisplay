<?php
require_once("../../../../includes/main.php");
$data = [];
if(isset($_GET['mac_address'])){
    $data['display'] = DisplayStamps::Stamp(Displays::MacAddress($_GET['mac_address']));
} else if(isset($_GET['room_id'])){
    $data['displays'] = Displays::Room($_GET['room_id']);
} else {
    $data['displays'] = DisplayStamps::AllDisplays();
}
OutputJson($data);
?>