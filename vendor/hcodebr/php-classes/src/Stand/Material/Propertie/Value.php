<?php

namespace Hcode\Stand\Material\Propertie;
 
 use Hcode\Model;
 use Hcode\Exception;

class Value extends Model {

    public $required = array('idproperty', 'desvalue');
    protected $pk = array(idmaterial, idproperty);

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_materialspropertiesvalues_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_materialspropertiesvalues_save(?, ?, ?, ?);", array(
                $this->getidmaterial(),
                $this->getidproperty(),
                $this->getdesvalue(),
                $this->getdtregister()
            ));

            return $this->getidmaterial();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_materialspropertiesvalues_remove", array(
            $this->getidmaterial()
        ));

        return true;
        
    }

}

?>