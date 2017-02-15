<?php

class CursoSecao extends Model {

    public $required = array('idsecao', 'dessecao', 'nrordem', 'idcurso');
    protected $pk = "idsecao";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cursossecoes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cursossecoes_save(?, ?, ?, ?);", array(
                $this->getidsecao(),
                $this->getdessecao(),
                $this->getnrordem(),
                $this->getidcurso()
            ));

            return $this->getidsecao();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_cursossecoes_remove", array(
            $this->getidsecao()
        ));

        return true;
        
    }

    public function getCurriculos():CursosCurriculos
    {
        return new CursosCurriculos($this);
    }

}

?>