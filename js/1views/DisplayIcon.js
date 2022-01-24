class DisplayStatusIcons extends View {
    
    constructor(debug = DisplaysCollection.debug_displays){
        if(debug) console.log("DisplayStatusIcons::Constructor");
        super(null,new Template("displays","/plugins/NullDisplay/templates/displays.html"),new Template("display","/plugins/NullDisplay/templates/display.html"),60000,debug);
    }
    build(){
        if(this.debug) console.warn("DisplayStatusIcons::Build missing room_id");
    }
    display(){
        if(this.debug) console.warn("DisplayStatusIcons::Display missing room_id");
    }
    refresh(){
        if(this.debug) console.warn("DisplayStatusIcons::Refresh missing room_id");
    }
    build(room_id){
        if(this.debug) console.log("DisplayStatusIcon::Build",room_id);
        if(room_id){
            if(this.template && this.item_template){
                this.template.getData(html=>{
                    this.item_template.getData(itm_html=>{
                        $(html).appendTo("[room_id="+room_id+"] .sensors");
                        DisplaysCollection.instance.roomDisplays(room_id,displays=>{
                            displays.forEach((display,index)=>{
                                $(itm_html).appendTo("[room_id="+room_id+"] .displays").attr("index",index);
                                $("[room_id="+room_id+"] .displays [index="+index+"]").attr("mac_address",display.mac_address);
                            });
                            this.display(room_id);
                        });
                    });
                });
            }    
        } else if(this.debug) console.warn("DisplayStatusIcons::Build(room_id) missing room_id",room_id);
    }
    display(room_id){
        if(this.debug) console.log("DisplayStatusIcon::Display",room_id);
        if(room_id){
            DisplaysCollection.instance.roomDisplays(room_id,displays=>{
                if(this.debug) console.log("DisplayStatusIcon::Display-display-list",room_id,displays);
                displays.forEach((display,index)=>{
                    if(this.debug) console.log("DisplayStatusIcon::Display-display_item",room_id,display);
                    $("main").attr("testing","hello world?");
                    $("[room_id="+room_id+"] .displays [index="+index+"]").attr("title",display.name);
                    $("[room_id="+room_id+"] .displays [index="+index+"]").attr("state",display.state);
                    $("[room_id="+room_id+"] .displays [index="+index+"]").attr("online",display.online);
                });
            });
        } else if(this.debug) console.warn("DisplayStatusIcons::Display missing room_id");
    }
}