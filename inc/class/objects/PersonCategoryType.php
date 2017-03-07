


<?php

class PersonCategoryType extends Model {

    public $required = array('idcategory', 'descategory');
    protected $pk = "idcategory";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_personscategoriestypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_personscategoriestypes_save(?, ?);", array(
                $this->getidcategory(),
                $this->getdescategory()
            ));

            return $this->getidcategory();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_personscategoriestypes_remove", array(
            $this->getidcategory()
        ));

        return true;
        
    }

}

?>