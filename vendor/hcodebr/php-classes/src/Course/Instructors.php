<?php

namespace Hcode\Course;

use Hcode\Collection;
use Hcode\Exception;
use Hcode\Course\Course;

class Instructors extends Collection {

    protected $class = "Hcode\Course\Instructor";
    protected $saveQuery = "sp_instructors_save";
    protected $saveArgs = array("idinstructor", "idperson", "desbiography", "idphoto");
    protected $pk = "idinstructor";

    public function get(){}

    public static function listAll():Instructors
    {

    	$instructors = new Instructors();

    	$instructors->loadFromQuery("CALL sp_instructors_list();");

    	return $instructors;

    }

    public function getByHcode_Course_Course(Course $course):Instructors
    {

        $this->loadFromQuery("CALL sp_instructorsfromcourse_list(?);", array(
            $course->getidcourse()
        ));

        return $this;

    }

}

?>