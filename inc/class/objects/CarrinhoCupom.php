<?php

class CarrinhoCupom extends Model {

    public $required = array('idcarrinho', 'idcupom');
    protected $pk = array('idcarrinho', 'idcupom');

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
        if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
        $this->queryToAttr("CALL sp_carrinhoscupons_get(".$args[0].", ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carrinhoscupons_save(?, ?);", array(
                $this->getidcarrinho(),
                $this->getidcupom()
            ));

            return $this->getidcarrinho();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_carrinhoscupons_remove", array(
            $this->getidcarrinho(),
            $this->getidcupom()
        ));

        return true;
        
    }

}

?>