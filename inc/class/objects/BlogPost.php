<?php

class BlogPost extends Model {

    public $required = array('destitle', 'idurl', 'descontentshort', 'descontent', 'idauthor', 'intrash');
    protected $pk = "idpost";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_blogposts_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_blogposts_save(?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidpost(),
                $this->getdestitle(),
                $this->getidurl(),
                $this->getdescontentshort(),
                $this->getdescontent(),
                $this->getidauthor(),
                $this->getdtpublished(),
                $this->getintrash(),
                $this->getidcover()
            ));

            return $this->getidpost();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_blogposts_remove", array(
            $this->getidpost()
        ));

        return true;
        
    }

}

?>