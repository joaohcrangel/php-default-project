<?php

class Setting extends Model {

    public $required = array('dessetting', 'desvalue', 'idsettingtype');
    protected $pk = "idsetting";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_settings_get(".$args[0].");");

    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            switch ($this->getidsettingtype()) {
                case Settingtype::STRING:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case SettingType::INT:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case SettingType::FLOAT:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case SettingType::BOOL:
                $this->desvalue((string)$this->getdesvalue());
                break;
                case SettingType::DATETIME:
                if (gettype($this->getdesvalue()) === 'object') {
                    $this->desvalue((string)$this->getdesvalue()->format('c'));
                }
                break;
                case SettingType::ARRAY:
                if (gettype($this->getdesvalue()) === 'array') {
                    $this->desvalue((string)json_encode($this->getdesvalue()));
                }
                break;
            }

            $this->queryToAttr("CALL sp_settings_save(?, ?, ?, ?, ?);", array(
                $this->getidsetting(),
                $this->getdessetting(),
                $this->getdesvalue(),
                $this->getdesdescription(),
                $this->getidsettingtype()
            ));

            return $this->getidsetting();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_settings_remove", array(
            $this->getidsetting()
        ));

        return true;
        
    }

    public function getValue(){

        switch ($this->getsettingstype()) {
            case SettingType::STRING:
            return (string)$this->getdesvalue();
            break;
            case SettingType::INT:
            return (int)$this->getdesvalue();
            break;
            case SettingType::FLOAT:
            return (float)$this->getdesvalue();
            break;
            case SettingType::BOOL:
            return (bool)$this->getdesvalue();
            break;
            case SettingType::DATETIME:
            return new DateTime($this->getdesvalue());
            break;
            case SettingType::ARRAY:
            return json_decode($this->getdesvalue(), true);
            break;
        }

    }

}

?>