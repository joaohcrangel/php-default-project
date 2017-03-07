


<?php

class Adress extends Model {

    public $required = array('idadress', 'idadresstype', 'desadress', 'desnumber', 'desdistrict', 'descity', 'desstate', 'descountry', 'descep');
    protected $pk = "idadress";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_adresses_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_adresses_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidadress(),
                $this->getidadresstype(),
                $this->getdesadress(),
                $this->getdesnumber(),
                $this->getdesdistrict(),
                $this->getdescity(),
                $this->getdesstate(),
                $this->getdescountry(),
                $this->getdescep(),
                $this->getdescomplement(),
                $this->getinprincipal(),
                $this->getdtregister()
            ));

            return $this->getidadress();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_adresses_remove", array(
            $this->getidadress()
        ));

        return true;
        
    }

}

?>