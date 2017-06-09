<?php

namespace Hcode\Stand\Material;
 
 use Hcode\Model;
 use Hcode\Exception;

class Type extends Model {

    public $required = array('destype');
    protected $pk = "idtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_materialstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_materialstypes_save(?, ?, ?);", array(
                $this->getidtype(),
                $this->getdestype(),
                $this->getdtregister()
            ));

            return $this->getidtype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_materialstypes_remove", array(
            $this->getidtype()
        ));

        return true;
        
    }

}

?>