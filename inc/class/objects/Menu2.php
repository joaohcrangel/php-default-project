


<?php

class Menu extends Model {

    public $required = array('idmenu', 'desmenu', 'desicon', 'deshref', 'nrorder', 'nrsubmenus');
    protected $pk = "idmenu";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_menus_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_menus_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidmenu(),
                $this->getidmenufather(),
                $this->getdesmenu(),
                $this->getdesicon(),
                $this->getdeshref(),
                $this->getnrorder(),
                $this->getnrsubmenus(),
                $this->getdtregister()
            ));

            return $this->getidmenu();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_menus_remove", array(
            $this->getidmenu()
        ));

        return true;
        
    }

}

?>