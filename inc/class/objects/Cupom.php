<?php

class Cupom extends Model {

    public $required = array('idcupom', 'idcupomtipo', 'descupom', 'descodigo', 'nrqtd', 'nrqtdusado', 'nrdesconto');
    protected $pk = "idcupom";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cupons_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cupons_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcupom(),
                $this->getidcupomtipo(),
                $this->getdescupom(),
                $this->getdescodigo(),
                $this->getnrqtd(),
                $this->getnrqtdusado(),
                $this->getdtinicio(),
                $this->getdttermino(),
                $this->getinremovido(),
                $this->getnrdesconto()
            ));

            return $this->getidcupom();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_cupons_remove", array(
            $this->getidcupom()
        ));

        return true;
        
    }

}

?>