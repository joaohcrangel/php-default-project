<?php

class CreditCards extends Collection {

    protected $class = "CreditCard";
    protected $saveQuery = "sp_creditcards_save";
    protected $saveArgs = array("idcard", "idperson", "desname", "dtvalidity", "nrcds", "desnumber");
    protected $pk = "idcard";
    public function get(){}

    public static function listAll(){

    	$cards = new class CreditCards();

    	$cards->loadFromQuery("CALL sp_creditcards_list();");

    	return $cards;

    }

    public function getByPerson(Person $person):CreditCards
    
    {
    
         $this->loadFromQuery("CALL sp_cardsfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }

}

?>