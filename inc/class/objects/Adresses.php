


<?php

class Adresses extends Collection {

    protected $class = "Adress";
    protected $saveQuery = "sp_adresses_save";
    protected $saveArgs = array("idadress", "idadresstype", "desadress", "desnumber", "desdistrict", "descity", "desstate", "descountry", "descep", "descomplement", "inprincipal", "dtregister");
    protected $pk = "idadress";

    public function get(){}

}

?>