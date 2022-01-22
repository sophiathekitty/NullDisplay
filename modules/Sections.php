<?php
/**
 * figure out which sections to show on a pitft micro display
 */
class SlideSections {
    /**
     * figure out which plugins and extensions are available
     * @return array list of sections
     */
    public static function Sections(){
        $sections = [];
        $sections[] = ["id"=>"1","name"=>"Clock"];
        if(HasPlugin("NullWeather")){
            $sections[] = ["id"=>"2","name"=>"Weather"];
        }
        /*
        if(HasPlugin("NullSensors")){
            $sections[] = ["id"=>"3","name"=>"Temperature"];
        }
        */
        /*
        if(HasExtension("MealPlanner")){
            $sections[] = ["id"=>"4","name"=>"Dinner"];
        }
        */
        return $sections;
    }
}

?>
