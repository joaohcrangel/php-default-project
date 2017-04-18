<?php

namespace Hcode\Site\Blog;

use \Hcode\Model;

class Author extends Model {

    public $required = array('iduser', 'desauthor');
    protected $pk = "idauthor";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_blogauthors_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_blogauthors_save(?, ?, ?, ?, ?);", array(
                $this->getidauthor(),
                $this->getiduser(),
                $this->getdesauthor(),
                $this->getdesresume(),
                $this->getidphoto()
            ));

            return $this->getidauthor();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_blogauthors_remove", array(
            $this->getidauthor()
        ));

        return true;
        
    }

}

?>