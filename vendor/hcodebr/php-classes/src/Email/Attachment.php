<?php

namespace Hcode\Email;

class Attachment extends Model {

    public $required = array('idemail', 'idfile');
    protected $pk = array(idemail, idfile);

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_emailsattachments_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_emailsattachments_save(?, ?, ?);", array(
                $this->getidemail(),
                $this->getidfile(),
                $this->getdtregister()
            ));

            return $this->getidemail();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_emailsattachments_remove", array(
            $this->getidemail()
        ));

        return true;
        
    }

}

?>