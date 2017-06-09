<?php

namespace Hcode\Course;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Course\Sections;
use Hcode\Course\Curriculum;
use Hcode\Site\Url;
use Hcode\Course\Instructors;
use Hcode\Course\Instructor;

class Course extends Model {

    public $required = array('idcourse', 'descourse', 'vlworkload', 'nrlessons', 'nrexercises', 'inremoved');
    protected $pk = "idcourse";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_courses_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_courses_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcourse(),
                $this->getdescourse(),
                $this->getdestitle(),
                $this->getvlworkload(),
                $this->getnrlessons(),
                $this->getnrexercises(),
                $this->getdesdescription(),
                $this->getinremoved()
            ));

            return $this->getidcourse();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_courses_remove", array(
            $this->getidcourse()
        ));

        return true;
        
    }

    public function getSections():Sections
    {
        return new Sections($this);
    }

    public function getCurriculum():Curriculum
    {
        return new Curriculum($this);
    }

    public function getInstructors():Instructors
    {
        return new Instructors($this);
    }

    public function getDescription():Course
    {

        $this->queryToAttr("SELECT desdescription, deswhatlearn, desrequirements, destargetaudience FROM tb_courses WHERE idcourse = ?;", array(
            $this->getidcourse()
        ));

        return $this;

    }

    public static function getByUrl($desurl):Course
    {

        $course = new Course();

        $course->queryToAttr("CALL sp_coursesbyurl_get(?);", array(
            $desurl
        ));

        return $course;

    }

    public function setInstructor(Instructor $instructor):Course
    {

        $this->queryToAttr("CALL sp_coursesinstructors_save(?, ?);", array(            
            $this->getidcourse(),
            $instructor->getidinstructor()
        ));

        return $this;

    }

    public function setUrl(Url $url):Course
    {

        $this->queryToAttr("CALL sp_coursesurls_save(?, ?);", array(
            $this->getidcourse(),
            $url->getidurl()
        ));

        return $this;

    }

}

?>