<?php

namespace Hcode;

class Orders extends Collection {

    protected $class = "Hcode\Order";
    protected $saveQuery = "sp_orders_save";
    protected $saveArgs = array("idorder", "idperson", "idformrequest", "idstatus", "dessession", "vltotal", "nrplots");
    protected $pk = "idorder";
    public function get(){}

    public static function listAll(){

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