<?php

namespace Hcode\Stand;
 
 use Hcode\Model;
 use Hcode\Exception;

class Department extends Model {

    public $required = array('iddepartmentparent', 'desdepartment');
    protected $pk = "iddepartment";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_departments_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_departments_save(?, ?, ?, ?);", array(
                $this->getiddepartment(),
                $this->getiddepartmentparent(),
                $this->getdesdepartment(),
                $this->getdtregister()
            ));

            return $this->getiddepartment();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_departments_remove", array(
            $this->getiddepartment()
        ));

        return true;
        
    }

}

?>