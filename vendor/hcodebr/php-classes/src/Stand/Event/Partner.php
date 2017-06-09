


<?php

class EventPartner extends Model {

    public $required = array('idperson');
    protected $pk = array(idcalendar, idperson);

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_eventspartners_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_eventspartners_save(?, ?, ?);", array(
                $this->getidcalendar(),
                $this->getidperson(),
                $this->getdtregister()
            ));

            return $this->getidcalendar();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_eventspartners_remove", array(
            $this->getidcalendar()
        ));

        return true;
        
    }

}

?>