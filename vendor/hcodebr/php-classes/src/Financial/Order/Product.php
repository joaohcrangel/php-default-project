<?php

namespace Hcode\Financial\Order;

use Hcode\Model;
use Hcode\Exception;

class Product extends Model {

    public $required = array('idorder', 'idproduct', 'nrqtd', 'vlprice', 'vltotal');
    protected $pk = "idorder";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_ordersproducts_get(".$args[0].", ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_ordersproducts_save(?, ?, ?, ?, ?);", array(
                $this->getidorder(),
                $this->getidproduct(),
                $this->getnrqtd(),
                $this->getvlprice(),
                $this->getvltotal()
            ));

            return $this->getidreques();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_ordersproducts_remove(".$this->getidorder().", ".$this->getidorder().")");

        return true;
        
    }

}

?>