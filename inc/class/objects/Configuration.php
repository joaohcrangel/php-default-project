<?php

class Configuration extends Model {

    public $required = array('desconfiguration', 'desvalue', 'idconfigurationtype');
    protected $pk = "idconfiguration";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_configurations_get(".$args[0].");");

    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            switch ($this->getidconfigurationtype()) {
                case Configurationtype::STRING:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case ConfigurationType::INT:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case ConfigurationType::FLOAT:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case ConfigurationType::BOOL:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case ConfigurationType::DATETIME:
                if (gettype($this->getdesvalue()) === 'object') {
                    $this->desvalue((string)$this->getdesvalue()->format('c'));
                }
                break;
                case ConfigurationType::ARRAY:
                if (gettype($this->getdesvalue()) === 'array') {
                    $this->desvalue((string)json_encode($this->getdesvalue()));
                }
                break;
            }

            $this->queryToAttr("CALL sp_configurations_save(?, ?, ?, ?, ?);", array(
                $this->getidconfiguration(),
                $this->getdesconfiguration(),
                $this->getdesvalue(),
                $this->getdesdescription(),
                $this->getidconfigurationtype()
            ));

            return $this->getidconfiguration();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_configurations_remove", array(
            $this->getidconfiguration()
        ));

        return true;
        
    }

    public function getValue(){

        switch ($this->getconfigurationstype()) {
            case ConfigurationType::STRING:
            return (string)$this->getdesvalue();
            break;
            case ConfigurationType::INT:
            return (int)$this->getdesvalue();
            break;
            case ConfigurationType::FLOAT:
            return (float)$this->getdesvalue();
            break;
            case ConfigurationType::BOOL:
            return (bool)$this->getdesvalue();
            break;
            case ConfigurationType::DATETIME:
            return new DateTime($this->getdesvalue());
            break;
            case ConfigurationType::ARRAY:
            return json_decode($this->getdesvalue(), true);
            break;
        }

    }

}

?>