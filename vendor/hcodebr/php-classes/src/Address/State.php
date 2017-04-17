<?php

namespace Hcode\Address;

use Hcode\Model;
use Hcode\Exception;

class State extends Model {

    public $required = array('desstate', 'desuf', 'idcountry');
    protected $pk = "idstate";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_states_get(".$args[0].");");
                
    }

    public static function loadFromUf($uf):State
    {

        $state = new State();

        $state->queryToAttr("
            SELECT * 
            FROM tb_states a
            INNER JOIN tb_countries b USING(idcountry)
            WHERE desuf = ?
        ", array(
            $uf
        ));

        return $state;

    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_states_save(?, ?, ?, ?);", array(
                $this->getidstate(),
                $this->getdesstate(),
                $this->getdesuf(),
                $this->getidcountry()
            ));

            return $this->getidstate();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_states_remove", array(
            $this->getidstate()
        ));

        return true;
        
    }

}

?>