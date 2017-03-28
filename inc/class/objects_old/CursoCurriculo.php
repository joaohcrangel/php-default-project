<?php

class CursoCurriculo extends Model {

    public $required = array('idcurriculo', 'descurriculo', 'idsecao');
    protected $pk = "idcurriculo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cursoscurriculos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cursoscurriculos_save(?, ?, ?, ?, ?);", array(
                $this->getidcurriculo(),
                $this->getdescurriculo(),
                $this->getidsecao(),
                $this->getdesdescricao(),
                $this->getnrordem()
            ));

            return $this->getidcurriculo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_cursoscurriculos_remove", array(
            $this->getidcurriculo()
        ));

        return true;
        
    }

}

?>