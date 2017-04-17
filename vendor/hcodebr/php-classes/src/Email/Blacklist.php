<?php

namespace Hcode\Email;

use Hcode\Model;
use Hcode\Exception;

class Blacklist extends Model {

    public $required = array('idblacklist', 'idcontact');
    protected $pk = "idblacklist";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_emailsblacklists_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_emailsblacklists_save(?, ?, ?);", array(
                $this->getidblacklist(),
                $this->getidcontact(),
                $this->getdtregister()
            ));

            return $this->getidblacklist();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_emailsblacklists_remove", array(
            $this->getidblacklist()
        ));

        return true;
        
    }

}

?>