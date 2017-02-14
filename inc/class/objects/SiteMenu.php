

<?php

class SiteMenu extends Model {

    public $required = array('desmenu', 'nrordem', 'desicone', 'deshref', 'nrsubmenus');
    protected $pk = "idmenu";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_sitesmenus_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_sitesmenus_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidmenu(),
                $this->getidmenupai(),
                $this->getdesmenu(),
                $this->getdesicone(),
                $this->getdeshref(),
                $this->getnrordem(),
                $this->getnrsubmenus()
            ));

            return $this->getidmenu();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_sitesmenus_remove", array(
            $this->getidmenu()
        ));

        return true;
        
    }

}

?>