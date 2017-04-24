<?php

namespace Hcode\Site\Blog;

use \Hcode\Model;

class Comment extends Model {

    public $required = array('idpost', 'idperson', 'descomment');
    protected $pk = "idcomment";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_blogcomments_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_blogcomments_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidcomment(),
                $this->getidcommentfather(),
                $this->getidpost(),
                $this->getidperson(),
                $this->getdescomment(),
                $this->getinapproved()
            ));

            return $this->getidcomment();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_blogcomments_remove", array(
            $this->getidcomment()
        ));

        return true;
        
    }

}

?>