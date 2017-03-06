


<?php

class LugaresValoresCampos extends Collection {

    protected $class = "LugarValorCampo";
    protected $saveQuery = "sp_lugaresvalorescampos_save";
    protected $saveArgs = array("idcampo", "descampo");
    protected $pk = "idcampo";

    public function get(){}

}

?>