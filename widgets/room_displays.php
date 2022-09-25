<?php
if(!isset($_GET['room_id'])) die();
require_once("../../../includes/main.php");
$displays = Displays::Room($_GET['room_id']);
if(count($displays) == 0) die();
?>
<span class="displays" collection="displays">
    <?php foreach($displays as $display){ ?>
    <span class="display" model="display" mac_address="<?=$display['mac_address']?>" title="<?=$display['name']?>" state="<?=$display['state']?>" online="<?=$display['online']?>"></span>
    <?php } ?>
</span>