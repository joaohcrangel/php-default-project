<?php

namespace Hcode\Site\Blog;

use \Hcode\Model;

class Category extends Model {

    public $required = array('descategory');
    protected $pk = "idcategory";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_blogcategories_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_blogcategories_save(?, ?, ?);", array(
                $this->getidcategory(),
                $this->getdescategory(),
                $this->getidurl()
            ));

            return $this->getidcategory();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_blogcategories_remove", array(
            $this->getidcategory()
        ));

        return true;
        
    }

}

?>