


<?php

class Cidades extends Collection {

    protected $class = "Cidade";
    protected $saveQuery = "sp_cidades_save";
    protected $saveArgs = array("idcidade", "descidade", "idestado");
    protected $pk = "idcidade";

    public function get(){}

}

?>