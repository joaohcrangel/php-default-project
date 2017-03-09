<?php

class Courses extends Collection {

    protected $class = "Course";
    protected $saveQuery = "sp_courses_save";
    protected $saveArgs = array("idcourse", "descourse", "destitle", "vlhours", "nrclassrooms", "nrexercise", "desdescription", "inremoved");
    protected $pk = "idcourse";

    public function get(){}

    public static function listAll():Courses
    {

    	$courses = new Courses();

    	$courses->loadFromQuery("CALL sp_courses_list();");

    	return $courses;

    }

}

?>