<?php

namespace Hcode\Shop\Product;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    public $required = array('desproducttype');
    protected $pk = "idproducttype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_productstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_productstypes_save(?, ?);", array(
                $this->getidproducttype(),
                $this->getdesproducttype()
            ));

            return $this->getidproducttype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_productstypes_remove", array(
            $this->getidproducttype()
        ));

        return true;
        
    }

}

?>