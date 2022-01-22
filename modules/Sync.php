<?php
class SyncDisplays {
    /**
     * figure out which sort of sync to do and do it
     * @return array sync report
     */
    public static function Sync(){
        if(Servers::IsMain()){
            return SyncDisplays::SyncFromDevices();
        } else {
            return SyncDisplays::SyncFromHub();
        }
    }
    /**
     * sync displays from hub
     * @return array sync report
     */
    public static function SyncFromHub(){
        $report = [];
        $url = "/plugins/NullDisplay/api/displays/";
        $hub = Servers::GetHub();
        if($hub['type'] == "old_hub") $url = "/api/displays/";
        $data = ServerRequests::LoadHubJSON($url);
        if(isset($data['displays'])){
            $report['saves'] = [];
            foreach($data['displays'] as $display){
                if($display['state'] == "unknown" && $display['type'] == "2"){
                    $room = Rooms::RoomId($display['room_id']);
                    if($room['lights_on_in_room']) $display['state'] = "day";
                    else $display['state'] = "night";
                    if(strpos($display['name'],"eInk")){
                        $display['state'] = "ready";
                    }
                }
                $report['saves'][] = Displays::SaveDisplay($display);
            }    
        } else {
            $report['error'] = "no displays found?";
        }
        return $report;
    }
    /**
     * sync individual displays from their devices
     * @return array sync report
     */
    public static function SyncFromDevices(){
        $report = [];
        $displays = Displays::AllDisplays();
        foreach($displays as $display){
            if(is_numeric($display['type']) && (int)$display['type'] == 5){
                $data = ServerRequests::LoadRemoteJSON($display['mac_address'],"/api/info/");
                if(isset($data['info'],$data['info']['display'])){
                    $display['name'] = $data['info']['name'];
                    $display['state'] = $data['info']['display']['state'];
                    $report[] = Displays::SaveDisplay($display);
                } else {
                    $report[] = "no display found at ".$display['mac_address']."/api/info/";
                }
            }
            if(is_numeric($display['type']) && (int)$display['type'] == 2){
                $data = ServerRequests::LoadRemoteJSON($display['mac_address'],"/api/info/");
                if(isset($data['info'],$data['info']['display'])){
                    $display['name'] = $data['info']['name'];
                    $room = Rooms::RoomId($display['room_id']);
                    if($room['lights_on_in_room']) $display['state'] = "day";
                    else $display['state'] = "night";
                    $report[] = Displays::SaveDisplay($display);
                } else {
                    $report[] = "no display found at ".$display['mac_address']."/api/info/";
                }
            }
            if($display['type'] == "pitft" || $display['type'] == "eInk"){
                $data = ServerRequests::LoadRemoteJSON($display['mac_address'],"/plugins/NullDisplay/api/displays/local/");
                if(isset($data['display']) && !is_null($data['display'])){
                    $report[] = Displays::SaveDisplay($data);
                } else {
                    $report[] = "no display found at ".$display['mac_address']."/plugins/NullDisplay/api/displays/local/";
                }
            }
        }
        return $report;
    }
}
?>
