<?php

namespace Hcode\Stand\Project;

use Hcode\Model;
use Hcode\Exception;

class Format extends Model {

    public $required = array('desformat');
    protected $pk = "idformat";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_projectsformats_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_projectsformats_save(?, ?, ?);", array(
                $this->getidformat(),
                $this->getdesformat(),
                $this->getdtregister()
            ));

            return $this->getidformat();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_projectsformats_remove", array(
            $this->getidformat()
        ));

        return true;
        
    }

}

?>