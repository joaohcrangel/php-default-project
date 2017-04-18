<?php

namespace Hcode\Site;

use Hcode\Model;
use Hcode\Exception;

class Url extends Model {

    public $required = array('desurl');
    protected $pk = "idurl";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_urls_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_urls_save(?, ?, ?);", array(
                $this->getidurl(),
                $this->getdesurl(),
                $this->getdestitle()
            ));

            return $this->getidurl();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_urls_remove", array(
            $this->getidurl()
        ));

        return true;
        
    }

}

?>