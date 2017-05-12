<?php

namespace Hcode\Course;

use Hcode\Collection;
use Hcode\Exception;
use Hcode\Course\Courses;

class Courses extends Collection {

    protected $class = "Hcode\Course\Course";
    protected $saveQuery = "sp_courses_save";
    protected $saveArgs = array("idcourse", "descourse", "destitle", "vlworkload", "nrlessons", "nrexercises", "desdescription", "inremoved");
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