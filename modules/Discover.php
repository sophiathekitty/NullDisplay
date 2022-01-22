<?php
class DisplayDiscover {
    /**
     * check the known servers to see if any are displays and make sure they're in the displays table
     * @return array save reports
     */
    public static function CheckServers(){
        $report = [];
        $servers = Servers::OnlineServers();
        foreach($servers as $server){
            switch($server['type']){
                case "micro display":
                case "display":
                case "pitft":
                case "eInk":
                    $display = DisplayDiscover::ServerToDisplay($server);
                    $report[] = Displays::SaveDisplay($display);
                    break;
            }
        }
        return $report;
    }
    /**
     * check to see if this device is a display. and if it is set it's type to display if it isn't
     */
    public static function DeviceIsDisplay(){
        $display = Displays::MacAddress(LocalMac());
        if(!is_null($display)){
            $type = Settings::LoadSettingsVar("type");
            switch($type){
                case "device":
                case "display":
                case "micro display":
                    Settings::SaveSettingsVar("type",$display['type']);
                    break;
            }
            $display['room_id'] = Settings::LoadSettingsVar("room_id",$display['room_id']);
        }
    }
    /**
     * converts a server into a display
     * @param array $server server data array
     * @return array display data array
     */
    private static function ServerToDisplay($server){
        $type = "unknown";
        if(strpos($server['name'],"Micro") > -1) $type = "pitft";
        if(strpos($server['name'],"eInk") > -1) $type = "eInk";
        $display = [
            "mac_address" => $server['mac_address'],
            "name" => $server['name'],
            "type" => $type,
            "room_id" => 0,
            "state" => "unknown"
        ];
        return $display;
    }
}
?>