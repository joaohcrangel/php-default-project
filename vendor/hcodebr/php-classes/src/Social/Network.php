<?php

namespace Hcode\Social;

use Hcode\Model;
use Hcode\Exception;

class Network extends Model {

    public $required = array('dessocialnetwork');
    protected $pk = "idsocialnetwork";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_socialnetworks_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_socialnetworks_save(?, ?);", array(
                $this->getidsocialnetwork(),
                $this->getdessocialnetwork()
            ));

            return $this->getidsocialnetwork();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_socialnetworks_remove", array(
            $this->getidsocialnetwork()
        ));

        return true;
        
    }

}

?>