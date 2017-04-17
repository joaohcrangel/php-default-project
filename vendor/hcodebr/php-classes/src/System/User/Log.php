<?php

namespace Hcode\System\User;

use Hcode\Model;
use Hcode\Exception;

class UserLog extends Model {

    public $required = array('iduser', 'idlogtype', 'deslog', 'desip', 'dessession', 'desuseragent', 'despath');
    protected $pk = "idlog";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_userslogs_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_userslogs_save(?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidlog(),
                $this->getiduser(),
                $this->getidlogtype(),
                $this->getdeslog(),
                $this->getdesip(),
                $this->getdessession(),
                $this->getdesuseragent(),
                $this->getdespath(),
                $this->getdtregister()
            ));

            return $this->getidlog();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_userslogs_remove", array(
            $this->getidlog()
        ));

        return true;
        
    }

}

?>