<?php

namespace Hcode\Stand\Project;

use Hcode\Model;
use Hcode\Exception;

class Statu extends Model {

    public $required = array('desstatus');
    protected $pk = "idstatus";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_projectsstatus_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_projectsstatus_save(?, ?, ?);", array(
                $this->getidstatus(),
                $this->getdesstatus(),
                $this->getdtregister()
            ));

            return $this->getidstatus();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_projectsstatus_remove", array(
            $this->getidstatus()
        ));

        return true;
        
    }

}

?>