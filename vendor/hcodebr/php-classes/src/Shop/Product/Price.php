<?php

namespace Hcode\Shop\Product;

use Hcode\Model;
use Hcode\Exception;

class Price extends Model {

    public $required = array('idprice', 'idproduct', 'dtstart', 'vlprice');
    protected $pk = "idprice";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_productsprices_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_productsprices_save(?, ?, ?, ?, ?);", array(
                $this->getidprice(),
                $this->getidproduct(),
                $this->getdtstart(),
                $this->getdtend(),
                $this->getvlprice()
            ));

            return $this->getidprice();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_productsprices_remove", array(
            $this->getidprice()
        ));

        return true;
        
    }

}

?>