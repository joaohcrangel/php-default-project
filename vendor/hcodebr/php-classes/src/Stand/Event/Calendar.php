<?php

namespace Hcode\Stand\Event;

use Hcode\Model;
use Hcode\Exception;

class Calendar extends Model {

    public $required = array('idevent', 'idplace', 'dtstart', 'dtend');
    protected $pk = "idcalendar";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_eventscalendars_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_eventscalendars_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidcalendar(),
                $this->getidevent(),
                $this->getidplace(),
                $this->getdtstart(),
                $this->getdtend(),
                $this->getdesurl()
            ));

            return $this->getidcalendar();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_eventscalendars_remove", array(
            $this->getidcalendar()
        ));

        return true;
        
    }

}

?>