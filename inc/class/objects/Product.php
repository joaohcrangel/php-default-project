


<?php

class Product extends Model {

    public $required = array('idproduct', 'idproducttype', 'desproduct', 'inremoved');
    protected $pk = "idproduct";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_products_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_products_save(?, ?, ?, ?, ?);", array(
                $this->getidproduct(),
                $this->getidproducttype(),
                $this->getdesproduct(),
                $this->getinremoved(),
                $this->getdtregister()
            ));

            return $this->getidproduct();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_products_remove", array(
            $this->getidproduct()
        ));

        return true;
        
    }

}

?>