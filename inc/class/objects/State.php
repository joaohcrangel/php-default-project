


<?php

class State extends Model {

    public $required = array('idstate', 'desstate', 'desuf', 'idcountry');
    protected $pk = "idstate";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_states_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_states_save(?, ?, ?, ?, ?);", array(
                $this->getidstate(),
                $this->getdesstate(),
                $this->getdesuf(),
                $this->getidcountry(),
                $this->getdtregister()
            ));

            return $this->getidstate();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_states_remove", array(
            $this->getidstate()
        ));

        return true;
        
    }

}

?>