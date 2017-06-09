


<?php

class EventCalendarFile extends Model {

    public $required = array('idfile');
    protected $pk = array(idcalendar, idfile);

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_eventscalendarsfiles_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_eventscalendarsfiles_save(?, ?, ?);", array(
                $this->getidcalendar(),
                $this->getidfile(),
                $this->getdtregister()
            ));

            return $this->getidcalendar();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_eventscalendarsfiles_remove", array(
            $this->getidcalendar()
        ));

        return true;
        
    }

}

?>