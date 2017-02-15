

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

            switch ($this->getidconfiguracaotipo()) {
                case ConfiguracaoTipo::STRING:
                $this->setdesvalor((string)$this->getdesvalor());
                break;
                case ConfiguracaoTipo::INT:
                $this->setdesvalor((string)$this->getdesvalor());
                break;
                case ConfiguracaoTipo::FLOAT:
                $this->setdesvalor((string)$this->getdesvalor());
                break;
                case ConfiguracaoTipo::BOOL:
                $this->setdesvalor((string)$this->getdesvalor());
                break;
                case ConfiguracaoTipo::DATETIME:
                if (gettype($this->getdesvalor()) === 'object') {
                    $this->setdesvalor((string)$this->getdesvalor()->format('c'));
                }
                break;
                case ConfiguracaoTipo::ARRAY:
                if (gettype($this->getdesvalor()) === 'array') {
                    $this->setdesvalor((string)json_encode($this->getdesvalor()));
                }
                break;
            }

            $this->queryToAttr("CALL sp_configuracoes_save(?, ?, ?, ?, ?);", array(
                $this->getidconfiguracao(),
                $this->getdesconfiguracao(),
                $this->getdesvalor(),
                $this->getdesdescricao(),
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
            case ConfiguracaoTipo::STRING:
            return (string)$this->getdesvalor();
            break;
            case ConfiguracaoTipo::INT:
            return (int)$this->getdesvalor();
            break;
            case ConfiguracaoTipo::FLOAT:
            return (float)$this->getdesvalor();
            break;
            case ConfiguracaoTipo::BOOL:
            return (bool)$this->getdesvalor();
            break;
            case ConfiguracaoTipo::DATETIME:
            return new DateTime($this->getdesvalor());
            break;
            case ConfiguracaoTipo::ARRAY:
            return json_decode($this->getdesvalor(), true);
            break;
        }

    }

}

?>