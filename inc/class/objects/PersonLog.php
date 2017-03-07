<?php

class PersonLog extends Model {

    public $required = array('idpersonlog', 'idperson', 'idlogtype', 'deslog');
    protected $pk = "idpersonlog";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_personslogs_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_personslogs_save(?, ?, ?, ?);", array(
                $this->getidpersonlog(),
                $this->getidperson(),
                $this->getidlogtype(),
                $this->getdeslog()
            ));

            return $this->getidpersonlog();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("sp_personslogs_remove", array(
            $this->getidpersonlog()
        ));

        return true;
        
    }

}

?>