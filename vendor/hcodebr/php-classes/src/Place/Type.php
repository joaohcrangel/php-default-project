<?php

namespace Hcode\Place;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    public $required = array('desplacetype');
    protected $pk = "idplacetype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_placestypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_placestypes_save(?, ?);", array(
                $this->getidplacetype(),
                $this->getdesplacetype()
            ));

            return $this->getidplacetype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_placestypes_remove", array(
            $this->getidplacetype()
        ));

        return true;
        
    }

}

?>