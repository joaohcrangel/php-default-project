<?php

class CoursesSections extends Collection {

    protected $class = "CourseSection";
    protected $saveQuery = "sp_coursessections_save";
    protected $saveArgs = array("idsection", "dessection", "nrordem", "idcourse");
    protected $pk = "idsection";

    public function get(){}

    public function getByCourse(Course $course):CoursesSections
    {

    	$this->loadFromQuery("CALL sp_sectionsfromcourse_list(?);", array(
    		$course->getidcourse()
    	));

    	return $this;

    }

}

?>