


<?php

class ProductType extends Model {

    public $required = array('idproducttype', 'desproducttype');
    protected $pk = "idproducttype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_productstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_productstypes_save(?, ?, ?);", array(
                $this->getidproducttype(),
                $this->getdesproducttype(),
                $this->getdtregister()
            ));

            return $this->getidproducttype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_productstypes_remove", array(
            $this->getidproducttype()
        ));

        return true;
        
    }

}

?>