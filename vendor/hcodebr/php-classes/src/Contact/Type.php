<?php

namespace Hcode\Contact;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    const EMAIL = 1;
    const TELEFONE = 2;

    public $required = array('descontacttype');
    protected $pk = "idcontacttype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contactstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contactstypes_save(?, ?);", array(
                $this->getidcontacttype(),
                $this->getdescontacttype()
            ));

            return $this->getidcontacttype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_contactstypes_remove", array(
            $this->getidcontacttype()
        ));

        return true;
        
    }

}

?>