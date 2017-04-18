<?php

namespace Hcode\Shop\Cart;

use Hcode\Model;
use Hcode\Exception;

class Freight extends Model {

    public $required = array('idcart', 'deszipcode', 'vlfreight');
    protected $pk = "idcart";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cartsfreights_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cartsfreights_save(?, ?, ?);", array(
                $this->getidcart(),
                $this->getdeszipcode(),
                $this->getvlfreight()
            ));

            return $this->getidcart();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_cartsfreights_remove", array(
            $this->getidcart()
        ));

        return true;
        
    }

}

?>