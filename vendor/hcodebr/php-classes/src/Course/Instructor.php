<?php

namespace Hcode\Course;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Course\Course;

class Instructor extends Model {

    public $required = array('idperson', 'desbiography', 'idphoto');
    protected $pk = "idinstructor";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_instructors_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_instructors_save(?, ?, ?, ?);", array(
                $this->getidinstructor(),
                $this->getidperson(),
                $this->getdesbiography(),
                $this->getidphoto()
            ));

            return $this->getidinstructor();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_instructors_remove", array(
            $this->getidinstructor()
        ));

        return true;
        
    }

}

?>