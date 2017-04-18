<?php

namespace Hcode\Financial;

use Hcode\Model;
use Hcode\Exception;

class CreditCard extends Model {

    public $required = array('idcard', 'idperson', 'desname', 'dtvalidity', 'nrcds', 'desnumber');
    protected $pk = "idcard";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_creditscards_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_creditscards_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidcard(),
                $this->getidperson(),
                $this->getdesname(),
                $this->getdtvalidity(),
                $this->getnrcds(),
                $this->getdesnumber()
            ));

            return $this->getidcard();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {
        
        $this->proc("sp_creditscards_remove", array(
            $this->getidcard()
        ));

        return true;
        
    }

}

?>