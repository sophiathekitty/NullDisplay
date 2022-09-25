<?php
/**
 * keeps track of the displays on the network
 */
class Displays extends clsModel {
    public $table_name = "Displays";
    public $fields = [
        [
            'Field'=>"mac_address",
            'Type'=>"varchar(200)",
            'Null'=>"NO",
            'Key'=>"PRI",
            'Default'=>"",
            'Extra'=>""
        ],[
            'Field'=>"name",
            'Type'=>"varchar(100)",
            'Null'=>"NO",
            'Key'=>"",
            'Default'=>"",
            'Extra'=>""
        ],[
            'Field'=>"type",
            'Type'=>"varchar(10)",
            'Null'=>"NO",
            'Key'=>"",
            'Default'=>"pitft",
            'Extra'=>""
        ],[
            'Field'=>"room_id",
            'Type'=>"int(11)",
            'Null'=>"NO",
            'Key'=>"",
            'Default'=>"0",
            'Extra'=>""
        ],[
            'Field'=>"state",
            'Type'=>"varchar(20)",
            'Null'=>"NO",
            'Key'=>"",
            'Default'=>"Unknown",
            'Extra'=>""
        ]
    ];
    private static $Displays;
    /**
     * @return Displays|clsModel 
     */
    private static function GetInstance(){
        if(is_null(Displays::$Displays)) Displays::$Displays = new Displays();
        return Displays::$Displays;
    }
    /**
     * get all the displays
     * @return array list of display data
     */
    public static function AllDisplays(){
        $displays = Displays::GetInstance();
        return $displays->LoadAll();
    }
    /**
     * get a display by mac address
     * @param string $mac_address the mac address of the server that runs the display
     * @return array display data
     */
    public static function Room($room_id){
        $displays = Displays::GetInstance();
        return $displays->LoadAllWhere(['room_id'=>$room_id]);
    }
    /**
     * get a display by mac address
     * @param string $mac_address the mac address of the server that runs the display
     * @return array display data
     */
    public static function MacAddress($mac_address){
        $displays = Displays::GetInstance();
        return $displays->LoadWhere(['mac_address'=>$mac_address]);
    }
    /**
     * saves a display
     * @param array $data the display data
     * @return array save report
     */
    public static function SaveDisplay(array $data){
        $displays = Displays::GetInstance();
        $data = $displays->CleanData($data);
        $display = Displays::MacAddress($data['mac_address']);
        if(is_null($display)){
            return $displays->Save($data);
        }
        return $displays->Save($data,['mac_address'=>$data['mac_address']]);
    }
}

if(defined('VALIDATE_TABLES')){
    clsModel::$models[] = new Displays();
}
?>