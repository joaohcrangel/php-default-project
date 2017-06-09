<?php

namespace Hcode\Stand\Event;

use Hcode\Model;
use Hcode\Exception;

class Organizer extends Model {

    public $required = array('desorganizer');
    protected $pk = "idorganizer";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_eventsorganizers_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_eventsorganizers_save(?, ?);", array(
                $this->getidorganizer(),
                $this->getdesorganizer()
            ));

            return $this->getidorganizer();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_eventsorganizers_remove", array(
            $this->getidorganizer()
        ));

        return true;
        
    }

}

?>