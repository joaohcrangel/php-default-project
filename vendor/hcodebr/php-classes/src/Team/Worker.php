<?php

namespace Hcode\Team;

use Hcode\Model;
use Hcode\Exception;
use Hcode\FileSystem;

class Worker extends Model {

    public $required = array('idperson', 'idjobposition');
    protected $pk = "idworker";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_workers_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_workers_save(?, ?, ?, ?);", array(
                $this->getidworker(),
                $this->getidperson(),
                $this->getidjobposition(),
                $this->getidphoto()
            ));

            return $this->getidworker();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_workers_remove", array(
            $this->getidworker()
        ));

        return true;
        
    }

}

?>