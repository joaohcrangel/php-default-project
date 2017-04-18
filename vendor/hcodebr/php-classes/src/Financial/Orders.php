<?php

namespace Hcode\Financial;

use Hcode\Collection;
use Hcode\Person\Person;

class Orders extends Collection {

    protected $class = "Hcode\Financial\Order";
    protected $saveQuery = "sp_orders_save";
    protected $saveArgs = array("idorder", "idperson", "idordermethod", "idstatus", "dessession", "vltotal", "nrparcels");
    protected $pk = "idorder";
    public function get(){}

    public static function listAll():Orders
    {

    	$orders = new Orders();

    	$orders->loadFromQuery("CALL sp_orders_list();");

    	return $orders;

    }

      public function getByPerson(Person $person):Orders
      
    {
    
         $this->loadFromQuery("CALL sp_ordersfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }

}

?>