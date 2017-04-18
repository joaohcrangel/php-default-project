<?php

namespace Hcode\Document;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    const CPF = 1;
    const CNPJ = 2;
    const RG = 3;

    public $required = array('iddocumenttype', 'desdocumenttype');
    protected $pk = "iddocumenttype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_documentstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_documentstypes_save(?, ?);", array(
                $this->getiddocumenttype(),
                $this->getdesdocumenttype()
            ));

            return $this->getiddocumenttype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_documentstypes_remove", array(
            $this->getiddocumenttype()
        ));

        return true;
        
    }

}

?>