<?php

namespace Hcode\Stand;

use Hcode\Model;
use Hcode\Exception;

class Event extends Model {

    public $required = array('desevent', 'idfrequency', 'nrfrequency', 'idorganizer');
    protected $pk = "idevent";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_events_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_events_save(?, ?, ?, ?, ?);", array(
                $this->getidevent(),
                $this->getdesevent(),
                $this->getidfrequency(),
                $this->getnrfrequency(),
                $this->getidorganizer()
            ));

            return $this->getidevent();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_events_remove", array(
            $this->getidevent()
        ));

        return true;
        
    }

}

?>