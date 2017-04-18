<?php

namespace Hcode\Course;

use Hcode\Collection;
use Hcode\Exception;
use Hcode\Course\Course;

class Sections extends Collection {

    protected $class = "Hcode\Course\Section";
    protected $saveQuery = "sp_coursessections_save";
    protected $saveArgs = array("idsection", "dessection", "nrordem", "idcourse");
    protected $pk = "idsection";

    public function get(){}

    public function getByCourse(Course $course):Sections
    {

    	$this->loadFromQuery("CALL sp_sectionsfromcourse_list(?);", array(
    		$course->getidcourse()
    	));

    	return $this;

    }

}

?>