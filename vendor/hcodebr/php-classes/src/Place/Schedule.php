<?php

namespace Hcode\Place;

use Hcode\Model;
use Hcode\Exception;

class Schedule extends Model {

    public $required = array('idplace', 'nrday');
    protected $pk = "idschedule";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_placesschedules_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_placesschedules_save(?, ?, ?, ?, ?);", array(
                $this->getidschedule(),
                $this->getidplace(),
                $this->getnrday(),
                $this->gethropen(),
                $this->gethrclose()
            ));

            return $this->getidschedule();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_placesschedules_remove", array(
            $this->getidhorario()
        ));

        return true;
        
    }

}

?>