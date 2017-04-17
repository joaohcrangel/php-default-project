<?php

namespace Hcode\System\User\Log;

use Hcode\Model;

class Type extends Model {

    public $required = array('idlogtype', 'deslogtype');
    protected $pk = "idlogtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_userslogstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_userslogstypes_save(?, ?, ?);", array(
                $this->getidlogtype(),
                $this->getdeslogtype(),
                $this->getdtregister()
            ));

            return $this->getidlogtype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_userslogstypes_remove", array(
            $this->getidlogtype()
        ));

        return true;
        
    }

}

?>