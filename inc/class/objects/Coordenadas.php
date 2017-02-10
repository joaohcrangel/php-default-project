<?php

class Coordenadas extends Collection {

    protected $class = "Coordenada";
    protected $saveQuery = "sp_coordenadas_save";
    protected $saveArgs = array("idcoordenada", "vllatitude", "vllongitude", "nrzoom");
    protected $pk = "idcoordenada";

    public function get(){}

}

?>