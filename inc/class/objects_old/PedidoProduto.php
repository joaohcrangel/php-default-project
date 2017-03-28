<?php

class RequestProduct extends Model {

    public $required = array('idrequest', 'idproduct', 'nrqtd', 'vlprice', 'vltotal');
    protected $pk = "idrequest";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_requestsproducts_get(".$args[0].", ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_requestsproducts_save(?, ?, ?, ?, ?);", array(
                $this->getidrequest(),
                $this->getidproduct(),
                $this->getnrqtd(),
                $this->getvlprice(),
                $this->getvltotal()
            ));

            return $this->getidreques();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_requestsproducts_remove(".$this->getidrequest().", ".$this->getidrequest().")");

        return true;
        
    }

}

?>