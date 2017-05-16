<?php

namespace Hcode\Contact;

use Hcode\Model;
use Hcode\Exception;

class Contact extends Model {

    public $required = array('idcontactsubtype', 'idperson', 'descontact', 'inmain');

    const EMAIL = 1;
    const TELEFONE = 2;

    protected $pk = "idcontact";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contacts_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contacts_save(?, ?, ?, ?, ?);", array(
                $this->getidcontact(),
                $this->getidcontactsubtype(),
                $this->getidperson(),
                $this->getdescontact(),
                $this->getinmain()
            ));

            return $this->getidcontact();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_contacts_remove", array(
            $this->getidcontact()
        ));

        return true;
        
    }

    public static function exists($descontact, $type)
    {

        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_contacts WHERE descontact = ? AND idcontacttype = ?", [
            $descontact,
            $type
        ]);

        return ($result['idcontact'] > 0)?new Contact($result):false;

    }

}

?>