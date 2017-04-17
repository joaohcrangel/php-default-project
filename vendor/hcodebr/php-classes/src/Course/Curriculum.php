<?php

namespace Hcode\Course;

use Hcode\Model;
use Hcode\Exception;

class Curriculum extends Model {

    public $required = array('idcurriculum', 'descurriculum', 'idsection');
    protected $pk = "idcurriculum";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_coursescurriculums_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_coursescurriculums_save(?, ?, ?, ?, ?);", array(
                $this->getidcurriculum(),
                $this->getdescurriculum(),
                $this->getidsection(),
                $this->getdesdescription(),
                $this->getnrorder()
            ));

            return $this->getidcurriculum();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_coursescurriculums_remove", array(
            $this->getidcurriculum()
        ));

        return true;
        
    }

}

?>