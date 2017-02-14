

<?php

class Configuracao extends Model {

    public $required = array('desconfiguracao', 'desvalor', 'idconfiguracaotipo');
    protected $pk = "idconfiguracao";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_configuracoes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_configuracoes_save(?, ?, ?, ?);", array(
                $this->getidconfiguracao(),
                $this->getdesconfiguracao(),
                $this->getdesvalor(),
                $this->getidconfiguracaotipo()
            ));

            return $this->getidconfiguracao();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_configuracoes_remove", array(
            $this->getidconfiguracao()
        ));

        return true;
        
    }

}

?>