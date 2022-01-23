<?php
class DisplayStamps {
    public static function AllDisplays(){
        $displays = Displays::AllDisplays();
        for($i = 0; $i < count($displays); $i++){
            $displays[$i] = DisplayStamps::Stamp($displays[$i]);
        }
        return $displays;
    }
    public static function Stamp($display){
        $server = Servers::ServerMacAddress($display['mac_address']);
        $display['online'] = $server['online'];
        return $display;
    }
}
?>
