<?php

class SiteContato extends Model {

    public $required = array('idsitecontato', 'idpessoa', 'desmensagem');
    protected $pk = "idsitecontato";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_sitescontatos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_sitescontatos_save(?, ?, ?, ?, ?);", array(
                $this->getidsitecontato(),
                $this->getidpessoa(),
                $this->getdesmensagem(),
                $this->getinlido(),
                $this->getidpessoaresposta()
            ));

            return $this->getidsitecontato();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_sitescontatos_remove(".$this->getidsitecontato().")");

        return true;
        
    }

}

?>