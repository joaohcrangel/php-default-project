<?php

 namespace Hcode\Stand;
 
 use Hcode\Model;
 use Hcode\Exception;


class Material extends Model {

    public $required = array('idmaterialtype', 'idunitytype', 'idphoto', 'desmaterial', 'descode', 'inreusable');
    protected $pk = "idmaterial";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_materials_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_materials_save(?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidmaterial(),
                $this->getidmaterialparent(),
                $this->getidmaterialtype(),
                $this->getidunitytype(),
                $this->getidphoto(),
                $this->getdesmaterial(),
                $this->getdescode(),
                $this->getinreusable(),
                $this->getdtregister()
            ));

            return $this->getidmaterial();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_materials_remove", array(
            $this->getidmaterial()
        ));

        return true;
        
    }

}

?>