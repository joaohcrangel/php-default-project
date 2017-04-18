<?php

namespace Hcode\Course;

use Hcode\Collection;
use Hcode\Exception;
use Hcode\Course\Course;

class Curriculums extends Collection {

    protected $class = "Hcode\Course\Curriculum";
    protected $saveQuery = "sp_coursescurriculums_save";
    protected $saveArgs = array("idcurriculum", "descurriculum", "idsection", "desdescription", "nrordem");
    protected $pk = "idcurriculum";

    public function get(){}

    public function getByCourse(Course $course):Curriculums
    {

    	$this->loadFromQuery("CALL sp_curriculumsfromcourses_list(?);", array(
    		$curso->getidcurso()
    	));

    	return $this;

    }

}

?>