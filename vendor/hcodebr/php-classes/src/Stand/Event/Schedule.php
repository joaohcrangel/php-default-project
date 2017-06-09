


<?php

class EventScheduleValue extends Model {

    public $required = array('idproperty', 'desvalue');
    protected $pk = array(idcalendar, idproperty);

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_eventsschedulesvalues_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_eventsschedulesvalues_save(?, ?, ?, ?);", array(
                $this->getidcalendar(),
                $this->getidproperty(),
                $this->getdesvalue(),
                $this->getdtregister()
            ));

            return $this->getidcalendar();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_eventsschedulesvalues_remove", array(
            $this->getidcalendar()
        ));

        return true;
        
    }

}

?>