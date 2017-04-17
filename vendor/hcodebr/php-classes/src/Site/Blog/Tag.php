<?php

namespace Hcode\Site\Blog;

use Hcode\Model;

class Tag extends Model {

    public $required = array('destag');
    protected $pk = "idtag";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_blogtags_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_blogtags_save(?, ?);", array(
                $this->getidtag(),
                $this->getdestag()
            ));

            return $this->getidtag();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_blogtags_remove", array(
            $this->getidtag()
        ));

        return true;
        
    }

}

?>