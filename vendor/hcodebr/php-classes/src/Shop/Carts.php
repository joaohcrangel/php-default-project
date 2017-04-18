<?php

namespace Hcode\Shop;

use Hcode\Collection;
use Hcode\Person\Person;

class Carts extends Collection {

    protected $class = "Hcode\Shop\Cart";
    protected $saveQuery = "sp_carts_save";
    protected $saveArgs = array("idcart", "idperson", "dessession", "inclosed", "nrproducts", "vltotal", "vltotalgross", "dtregister");
    protected $pk = "idcart";

    public function get(){}

    public static function listAll():Carts
    {

    	$carts = new Carts();

    	$carts->loadFromQuery("CALL sp_carts_list();");

    	return $carts;

    }

     public function getByPerson(Person $person):Carts    
    {
    
         $this->loadFromQuery("CALL sp_cartsfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }

}

?>