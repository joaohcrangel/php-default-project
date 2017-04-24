<?php

namespace Hcode\System\User;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    const ADMINISTRATIVO = 1;
    const CLIENTE = 2;

    public $required = array('desusertype');
    protected $pk = "idusertype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_userstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_userstypes_save(?, ?);", array(
                $this->getidusertype(),
                $this->getdesusertype()
            ));

            return $this->getidusertype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_userstypes_remove", array(
            $this->getidusertype()
        ));

        return true;
        
    }

}

?>