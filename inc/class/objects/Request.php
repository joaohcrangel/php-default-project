<?php

class Request extends Model {

    public $required = array('idrequest', 'idperson', 'idformrequest', 'idstatus', 'dessession', 'vltotal', 'nrplots');
    protected $pk = "idrequest";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_requests_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_requests_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidrequest(),
                $this->getidperson(),
                $this->getidformrequest(),
                $this->getidstatus(),
                $this->getdessession(),
                $this->getvltotal(),
                $this->getnrplots()
            ));

            return $this->getidrequest();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_requests_remove(".$this->getidrequest().")");

        return true;
        
    }

    public function getReceipts(){

        $receipts = new  Requests();

        $receipts->loadFromQuery("CALL sp_receiptsfromrequests_list(?);", array(
            $this->getidrequest()
        ));

        return $recibos;

    }

}

?>