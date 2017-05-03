<?php

namespace Hcode\Team\Job;

use Hcode\Model;
use Hcode\Exception;

class Position extends Model {

    public $required = array('desjobposition');
    protected $pk = "idjobposition";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_jobspositions_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_jobspositions_save(?, ?);", array(
                $this->getidjobposition(),
                $this->getdesjobposition()
            ));

            return $this->getidjobposition();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_jobspositions_remove", array(
            $this->getidjobposition()
        ));

        return true;
        
    }

}

?>