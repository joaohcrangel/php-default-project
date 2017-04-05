<?php

namespace Hcode;

class LogType extends Model {

    public $required = array('idlogtype', 'deslogtype');
    protected $pk = "idlogtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_logstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_logstypes_save(?, ?);", array(
                $this->getidlogtype(),
                $this->getdeslogtype()
            ));

            return $this->getidlogtype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_logstypes_remove", array(
            $this->getidlogtype()
        ));

        return true;
        
    }

}

?>