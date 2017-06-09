<?php

class Materials extends Collection {

    protected $class = "Material";
    protected $saveQuery = "sp_materials_save";
    protected $saveArgs = array("idmaterial", "idmaterialparent", "idmaterialtype", "idunitytype", "desmaterial", "descode", "inreusable", "dtregister");
    protected $pk = "idmaterial";

    public function get(){}

}

?>