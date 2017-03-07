<?php

class CreditCard extends Model {

    public $required = array('idcard', 'idperson', 'desname', 'dtvalidity', 'nrcds', 'desnumber');
    protected $pk = "idcard";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_creditcards_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_creditcards_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidcard(),
                $this->getidperson(),
                $this->getdesname(),
                $this->getdtvalidity(),
                $this->getnrcds(),
                $this->getdesnumber()
            ));

            return $this->getidcard();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_creditcards_remove(".$this->getidcard().")");

        return true;
        
    }

}

?>