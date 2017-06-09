<?php

namespace Hcode\Stand\Project\Item;

use Hcode\Model;
use Hcode\Exception;

class Relation extends Model {

    public $required = array('iditem', 'vlqtd');
    protected $pk = array('idproject', 'iditem');

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_projectsitemsrelations_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_projectsitemsrelations_save(?, ?, ?, ?, ?);", array(
                $this->getidproject(),
                $this->getiditem(),
                $this->getvlqtd(),
                $this->getdesobs(),
                $this->getdtregister()
            ));

            return $this->getidproject();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_projectsitemsrelations_remove", array(
            $this->getidproject()
        ));

        return true;
        
    }

}

?>