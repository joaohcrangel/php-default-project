<?php

namespace Hcode\Site;

use Hcode\Model;
use Hcode\Exception;

class Category extends Model {

    public $required = array('idcategory', 'descategory');
    protected $pk = "idcategory";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_categories_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_categories_save(?, ?, ?);", array(
                $this->getidcategory(),
                $this->getidcategoryfather(),
                $this->getdescategory()
            ));

            return $this->getidcategory();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_categories_remove", array(
            $this->getidcategory()
        ));

        return true;
        
    }

}

?>