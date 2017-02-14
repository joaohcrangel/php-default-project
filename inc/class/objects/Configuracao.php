

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

    public function getValue(){

        switch ($this->getidconfiguracaotipo()) {
            case 1:
            return (string)$this->getdesvalor();
            break;
            case 2:
            return (float)$this->getdesvalor();
            break;
            case 3:
            return (bool)$this->getdesvalor();
            break;
            case 4:
            return new DateTime($this->getdesvalor());
            break;
        }

    }

}

?>