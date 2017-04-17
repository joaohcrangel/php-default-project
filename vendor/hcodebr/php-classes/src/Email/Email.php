<?php

namespace Hcode\Email;

use Hcode\Model;
use Hcode\Exception;

class Email extends Model {

    public $required = array('desemail', 'dessubject', 'desbody');
    protected $pk = "idemail";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_emails_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_emails_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidemail(),
                $this->getdesemail(),
                $this->getdessubject(),
                $this->getdesbody(),
                $this->getdesbcc(),
                $this->getdescc(),
                $this->getdesreplyto(),
                $this->getdtregister()
            ));

            return $this->getidemail();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_emails_remove", array(
            $this->getidemail()
        ));

        return true;
        
    }

}

?>