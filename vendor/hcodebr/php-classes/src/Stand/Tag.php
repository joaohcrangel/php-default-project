<?php

 namespace Hcode\Stand;
 
 use Hcode\Model;
 use Hcode\Exception;

class Tag extends Model {

    public $required = array('destag', 'inactive');
    protected $pk = "idtag";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_tags_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_tags_save(?, ?, ?, ?);", array(
                $this->getidtag(),
                $this->getdestag(),
                $this->getinactive(),
                $this->getdtregister()
            ));

            return $this->getidtag();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_tags_remove", array(
            $this->getidtag()
        ));

        return true;
        
    }

}

?>