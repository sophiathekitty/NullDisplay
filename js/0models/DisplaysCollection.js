class DisplaysCollection extends Collection {
    static instance = new DisplaysCollection();
    static debug_displays = false;
    constructor(debug = DisplaysCollection.debug_displays){
        if(debug) console.log("DisplaysCollection::Constructor");
        super("displays","display","/plugins/NullDisplay/api/displays","/plugins/NullDisplay/api/displays/save","mac_address","collection_",debug);
    }

    roomDisplays(room_id,callBack){
        this.get_params = "?room_id="+room_id;
        this.getData(json=>{
            var displays = [];
            json.displays.forEach(display=>{
                if(display.room_id == room_id){
                    displays.push(display);
                }
            });
            callBack(displays);
        });
    }
}