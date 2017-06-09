<?php

namespace Hcode\Stand\Project;

use Hcode\Model;
use Hcode\Exception;

class Item extends Model {

    public $required = array('desitem');
    protected $pk = "iditem";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_projectsitems_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_projectsitems_save(?, ?, ?);", array(
                $this->getiditem(),
                $this->getdesitem(),
                $this->getdtregister()
            ));

            return $this->getiditem();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_projectsitems_remove", array(
            $this->getiditem()
        ));

        return true;
        
    }

}

?>