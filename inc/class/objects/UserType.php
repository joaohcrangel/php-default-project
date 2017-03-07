


<?php

class UserType extends Model {

    public $required = array('idusertype', 'desusertype');
    protected $pk = "idusertype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_userstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_userstypes_save(?, ?, ?);", array(
                $this->getidusertype(),
                $this->getdesusertype(),
                $this->getdtregister()
            ));

            return $this->getidusertype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_userstypes_remove", array(
            $this->getidusertype()
        ));

        return true;
        
    }

}

?>