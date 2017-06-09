<?php

namespace Hcode\Stand;

use Hcode\Model;
use Hcode\Exception;

class ProjectStandType extends Model {

    public $required = array('desstandtype');
    protected $pk = "idstandtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_projectsstandstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_projectsstandstypes_save(?, ?, ?);", array(
                $this->getidstandtype(),
                $this->getdesstandtype(),
                $this->getdtregister()
            ));

            return $this->getidstandtype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_projectsstandstypes_remove", array(
            $this->getidstandtype()
        ));

        return true;
        
    }

}

?>