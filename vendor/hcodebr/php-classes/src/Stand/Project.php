<?php
 
 namespace Hcode\Stand;
 
 use Hcode\Model;
 use Hcode\Exception;

class Project extends Model {

    public $required = array('desproject', 'descode', 'idclient', 'idsalesman', 'idcalendar', 'idformat', 'idstandtype', 'vlsum');
    protected $pk = "idproject";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_projects_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_projects_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidproject(),
                $this->getdesproject(),
                $this->getdescode(),
                $this->getidclient(),
                $this->getidsalesman(),
                $this->getdtdue(),
                $this->getdtdelivery(),
                $this->getidcalendar(),
                $this->getidformat(),
                $this->getidstandtype(),
                $this->getvlsum(),
                $this->getdesdescription(),
                $this->getdtregister()
            ));

            return $this->getidproject();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_projects_remove", array(
            $this->getidproject()
        ));

        return true;
        
    }

}

?>