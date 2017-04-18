<?php

namespace Hcode\Site\Carousel\Item;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    public $required = array('idtype', 'destype');
    protected $pk = "idtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carouselsitemstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carouselsitemstypes_save(?, ?);", array(
                $this->getidtype(),
                $this->getdestype()
            ));

            return $this->getidtype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_carouselsitemstypes_remove", array(
            $this->getidtype()
        ));

        return true;
        
    }

}

?>