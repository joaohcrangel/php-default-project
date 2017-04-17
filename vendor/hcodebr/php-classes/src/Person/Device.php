<?php

namespace Hcode;

use Hcode\Model;
use Hcode\Exception;

class Device extends Model {

    public $required = array('iddevice', 'idperson', 'desdevice', 'desid', 'dessystem');
    protected $pk = "iddevice";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_personsdevices_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_personsdevices_save(?, ?, ?, ?, ?);", array(
                $this->getiddevice(),
                $this->getidperson(),
                $this->getdesdevice(),
                $this->getdesid(),
                $this->getdessystem()
            ));

            return $this->getiddevice();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_personsdevices_remove", array(
            $this->getiddevice()
        ));

        return true;
        
    }

}

?>