<?php

class Estado extends Model {

    public $required = array('idestado', 'desestado', 'desuf', 'idpais');
    protected $pk = "idestado";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_estados_get(".$args[0].");");
                
    }

    public static function loadFromUf($uf):Estado
    {

        $estado = new Estado();

        $estado->queryToAttr("
            SELECT * 
            FROM tb_estados a
            INNER JOIN tb_paises b USING(idpais)
            WHERE desuf = ?
        ", array(
            $uf
        ));

        return $estado;

    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_estados_save(?, ?, ?, ?);", array(
                $this->getidestado(),
                $this->getdesestado(),
                $this->getdesuf(),
                $this->getidpais()
            ));

            return $this->getidestado();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_estados_remove", array(
            $this->getidestado()
        ));

        return true;
        
    }

}

?>