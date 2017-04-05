<?php

class CreditsCards extends Collection {

    protected $class = "CreditCard";
    protected $saveQuery = "sp_creditscards_save";
    protected $saveArgs = array("idcard", "idperson", "desname", "dtvalidity", "nrcds", "desnumber");
    protected $pk = "idcard";
    public function get(){}

    public static function listAll():CreditsCards
    {

    	$cards = new CreditsCards();

    	$cards->loadFromQuery("CALL sp_creditscards_list();");

    	return $cards;

    }

    public function getByPerson(Person $person):CreditsCards
    
    {
    
         $this->loadFromQuery("CALL sp_cardsfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }

}

?>