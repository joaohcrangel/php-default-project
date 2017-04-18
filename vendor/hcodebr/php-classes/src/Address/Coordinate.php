<?php

namespace Hcode\Address;

use Hcode\Model;
use Hcode\Exception;

class Coordinate extends Model {

    public $required = array('vllatitude', 'vllongitude', 'nrzoom');
    protected $pk = "idcoordinate";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_coordinates_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_coordinates_save(?, ?, ?, ?);", array(
                $this->getidcoordinate(),
                $this->getvllatitude(),
                $this->getvllongitude(),
                $this->getnrzoom()
            ));

            return $this->getidcoordinate();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_coordinates_remove(".$this->getidcoordinate().")");

        return true;
        
    }

}

?>