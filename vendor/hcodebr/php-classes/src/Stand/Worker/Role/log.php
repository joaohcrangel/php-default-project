


<?php

class Workersroleslog extends Model {

    public $required = array('idworker', 'idrole', 'vlsalary', 'dtstart');
    protected $pk = "idhistory";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_workersroleslogs_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_workersroleslogs_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidhistory(),
                $this->getidworker(),
                $this->getidrole(),
                $this->getvlsalary(),
                $this->getdtstart(),
                $this->getdtend(),
                $this->getdtregister()
            ));

            return $this->getidhistory();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_workersroleslogs_remove", array(
            $this->getidhistory()
        ));

        return true;
        
    }

}

?>