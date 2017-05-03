<?php

namespace Hcode\Address;

use Hcode\Collection;
use Hcode\Person\Person;
use Hcode\Place\PLace;

class Addresses extends Collection {

    protected $class = "Hcode\Address\Address";
    protected $saveQuery = "sp_addresses_save";
    protected $saveArgs = array("idaddress", "idaddresstype", "desaddress", "desnumber", "desdistrict", "descity", "desstate", "descountry", "descep", "descomplement", "inmain");
    protected $pk = "idaddress";

    public function get(){}

    public static function listAll():Addresses
    {

     	$addresses = new Addresses();

    	$addresses->loadFromQuery("CALL sp_addresses_list()");

    	return $addresses;

     }

    public static function listFromPerson(Person $idperson):Addresses
    {

    	$addresses = new Addresses();

    	$addresses->loadFromQuery("CALL sp_addressesfromperson_list(?);", array(
    		(int)$idperson
    	));

    	return $addresses;

    }

    public function getByHcode_Person_Person(Person $person):Addresses
    {

        $this->loadFromQuery("CALL sp_addressesfromperson_list(?);", array(
            $person->getidperson()
        ));

        return $this;

    }

    public function getByPlace(Place $place):Addresses
    {

        $this->loadFromQuery("CALL sp_addressesfromplace_list(?);", array(
            $place->getidplace()
        ));

        return $this;

    }

}

?>