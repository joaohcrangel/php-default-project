<?php

class RequestReceipt extends Model {

    public $required = array('idrequest', 'desauthentication');
    protected $pk = "idrequest";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_requestsreceipts_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_requestsreceipts_save(?, ?);", array(
                $this->getidrequest(),
                $this->getdesauthentication()
            ));

            return $this->getidrequest();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_requestsreceipts_remove(".$this->getidrequest().")");

        return true;
        
    }

}

?>