<?php

namespace Hcode\Stand\Project;

use Hcode\Model;
use Hcode\Exception;


class Log extends Model {

    public $required = array('idproject', 'idstatus');
    protected $pk = "idlog";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_projectslogs_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_projectslogs_save(?, ?, ?, ?);", array(
                $this->getidlog(),
                $this->getidproject(),
                $this->getidstatus(),
                $this->getdtregister()
            ));

            return $this->getidlog();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_projectslogs_remove", array(
            $this->getidlog()
        ));

        return true;
        
    }

}

?>