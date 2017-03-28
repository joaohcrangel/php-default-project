<?php

class CoursesCurriculums extends Collection {

    protected $class = "CourseCurriculum";
    protected $saveQuery = "sp_coursescurriculums_save";
    protected $saveArgs = array("idcurriculum", "descurriculum", "idsection", "desdescription", "nrordem");
    protected $pk = "idcurriculum";

    public function get(){}

    public function getByCourse(Course $course):CoursesCurriculums
    {

    	$this->loadFromQuery("CALL sp_curriculumsfromcourses_list(?);", array(
    		$curso->getidcurso()
    	));

    	return $this;

    }

}

?>