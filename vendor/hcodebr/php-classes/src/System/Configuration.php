<?php

namespace Hcode\System;

use Hcode\Model;
use Hcode\Exception;
use Hcode\System\Configuration\Type;

class Configuration extends Model {

    public $required = array('desconfiguration', 'desvalue', 'idconfigurationtype');
    protected $pk = "idconfiguration";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_configurations_get(".$args[0].");");

    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){
            
            switch ($this->getidconfigurationtype()) {
                
                case Type::STRING:
                $this->setdesvalue((string)$this->getdesvalue());
                break;

                case Type::INT:
                $this->setdesvalue((int)$this->getdesvalue());
                break;

                case Type::FLOAT:
                $this->setdesvalue((float)$this->getdesvalue());
                break;

                case Type::BOOL:
                $this->setdesvalue((bool)$this->getdesvalue());
                break;

                case Type::DATETIME:
                if (gettype($this->getdesvalue()) === 'object') {
                    $this->setdesvalue((string)$this->getdesvalue()->format('c'));
                }
                break;

                case Type::ARRAY:
                if (gettype($this->getdesvalue()) === 'array') {
                    $this->setdesvalue((string)json_encode($this->getdesvalue()));
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

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_configurations_remove", array(
            $this->getidconfiguration()
        ));

        return true;
        
    }

    public function getValue(){

        switch ($this->getidconfigurationtype()) {
            case Type::STRING:
            return (string)$this->getdesvalue();
            break;
            case Type::INT:
            return (int)$this->getdesvalue();
            break;
            case Type::FLOAT:
            return (float)$this->getdesvalue();
            break;
            case Type::BOOL:
            return (bool)$this->getdesvalue();
            break;
            case Type::DATETIME:
            return new DateTime($this->getdesvalue());
            break;
            case Type::ARRAY:
            return json_decode($this->getdesvalue(), true);
            break;
        }

    }

}

?>