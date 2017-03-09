<?php

class Course extends Model {

    public $required = array('idcourse', 'descourse', 'vlhours', 'nrclassrooms', 'nrexercise ', 'inremoved');
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
                $this->getvlhours(),
                $this->getnrclassrooms(),
                $this->getnrexercise(),
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

    public function getSections():CoursesSections
    {
        return new CoursesSections($this);
    }

    public function getCurriculum():CoursesCurriculum
    {
        return new CoursesCurriculum($this);
    }

}

?>