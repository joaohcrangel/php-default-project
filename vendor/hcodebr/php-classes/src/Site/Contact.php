<?php

namespace Hcode\Site;

use Hcode\Model;
use Hcode\Exception;

class Contact extends Model {

    public $required = array('idperson', 'desmessage');
    protected $pk = "idsitecontact";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_sitescontacts_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_sitescontacts_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidsitecontact(),
                $this->getidsitecontactfather(),
                $this->getidperson(),
                $this->getdesmessage(),
                $this->getinread(),
                $this->getidpersonanswer()
            ));

            return $this->getidsitecontact();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("CALL sp_sitescontacts_remove(".$this->getidsitecontact().")");

        return true;
        
    }

}

?>