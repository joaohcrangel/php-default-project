<?php

namespace Hcode\Stand\Event;

use Hcode\Model;
use Hcode\Exception;

class Frequency extends Model {

    public $required = array('desfrequency');
    protected $pk = "idfrequency";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_eventsfrequencies_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_eventsfrequencies_save(?, ?);", array(
                $this->getidfrequency(),
                $this->getdesfrequency()
            ));

            return $this->getidfrequency();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_eventsfrequencies_remove", array(
            $this->getidfrequency()
        ));

        return true;
        
    }

}

?>