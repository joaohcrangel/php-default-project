<?php

namespace Hcode\Course;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Course\Curriculums;

class Section extends Model {

    public $required = array('idsection', 'dessection', 'nrorder', 'idcourse');
    protected $pk = "idsection";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_coursessections_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_coursessections_save(?, ?, ?, ?);", array(
                $this->getidsection(),
                $this->getdessection(),
                $this->getnrorder(),
                $this->getidcourse()
            ));

            return $this->getidsection();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_coursessections_remove", array(
            $this->getidsection()
        ));

        return true;
        
    }

    public function getCurriculums():Curriculums
    {
        return new Curriculums($this);
    }

}

?>