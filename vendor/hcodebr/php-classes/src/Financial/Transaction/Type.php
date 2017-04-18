<?php

namespace Hcode\Financial\Transaction;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    public $required = array('destransactiontype');
    protected $pk = "idtransactiontype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_transactionstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_transactionstypes_save(?, ?, ?);", array(
                $this->getidtransactiontype(),
                $this->getdestransactiontype(),
                $this->getdtregister()
            ));

            return $this->getidtransactiontype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_transactionstypes_remove", array(
            $this->getidtransactiontype()
        ));

        return true;
        
    }

}

?>