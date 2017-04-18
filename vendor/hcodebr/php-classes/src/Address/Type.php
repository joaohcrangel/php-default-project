<?php

namespace Hcode\Address;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    const RESIDENCIAL = 1;
    const COMERCIAL = 2;
    const COBRANCA = 3;
    const ENTREGA = 4;

    public $required = array('desaddresstype');
    protected $pk = "idaddresstype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_addressestypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_addressestypes_save(?, ?);", array(
                $this->getidaddresstype(),
                $this->getdesaddresstype()
            ));

            return $this->getidaddresstype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_addressestypes_remove", array(
            $this->getidaddresstype()
        ));

        return true;
        
    }

}

?>