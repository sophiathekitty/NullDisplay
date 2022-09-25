<?php
/**
 * generate stamp for displays
 */
class DisplayStamps {
    /**
     * loads all displays with the server online added
     * @return array array of displays with the server online added
     */
    public static function AllDisplays(){
        $displays = Displays::AllDisplays();
        for($i = 0; $i < count($displays); $i++){
            $displays[$i] = DisplayStamps::Stamp($displays[$i]);
        }
        return $displays;
    }
    /**
     * load all displays in room with the server online added
     * @param int $room_id the room id...
     * @return array array of displays with the server online added
     */
    public static function RoomDisplays($room_id){
        $displays = Displays::Room($room_id);
        for($i = 0; $i < count($displays); $i++){
            $displays[$i] = DisplayStamps::Stamp($displays[$i]);
        }
        return $displays;
    }
    /**
     * create a stamp from a display model array... adds server online field
     * @param array $display the data array loaded from the display model
     * @return array the display data array with the server online added
     */
    public static function Stamp($display){
        $server = Servers::ServerMacAddress($display['mac_address']);
        $display['online'] = $server['online'];
        return $display;
    }
}
?>
