<?php
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
            'Default'=>"",
            'Extra'=>""
        ],[
            'Field'=>"room_id",
            'Type'=>"int(11)",
            'Null'=>"NO",
            'Key'=>"",
            'Default'=>"",
            'Extra'=>""
        ],[
            'Field'=>"state",
            'Type'=>"varchar(20)",
            'Null'=>"NO",
            'Key'=>"",
            'Default'=>"",
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
    public static function AllDisplays(){
        $displays = Displays::GetInstance();
        return $displays->LoadAll();
    }
    public static function MacAddress($mac_address){
        $displays = Displays::GetInstance();
        return $displays->LoadWhere(['mac_address'=>$mac_address]);
    }
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