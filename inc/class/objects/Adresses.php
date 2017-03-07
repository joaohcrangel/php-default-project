<?php

class Adresses extends Collection {

    protected $class = "Adress";
    protected $saveQuery = "sp_adresses_save";
    protected $saveArgs = array("idadress", "idadresstype", "desadress", "desnumber", "desdistrict", "descity", "desstate", "descountry", "descep", "descomplement", "inmain");
    protected $pk = "idadress";

    public function get(){}

    public static function listAll():Adresses
    {

     	$adresses = new Adresses();

    	$adresses->loadFromQuery("CALL sp_adresses_list()");

    	return $adresses;

     }

    public static function listFromPerson(Person $idperson):Adresses
    {

    	$adresses = new Adresses();

    	$adresses->loadFromQuery("CALL sp_adressesfromperson_list(?);", array(
    		(int)$idperson
    	));

    	return $adresses;

    }

    public function getByPerson(Person $person):Adresses
    {

        $this->loadFromQuery("CALL sp_adressesfromperson_list(?);", array(
            $person->getidperson()
        ));

        return $this;

    }

    public function getByPlace(Place $place):Adresses
    {

        $this->loadFromQuery("CALL sp_adressesfromplace_list(?);", array(
            $place->getidplace()
        ));

        return $this;

    }

}

?>