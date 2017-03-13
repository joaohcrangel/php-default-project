<?php

class ContactSubType extends Model {

    const TELEFONE_CASA = 1;
    const TELEFONE_TRABALHO = 2;
    const TELEFONE_CELULAR = 3;
    const TELEFONE_FAX = 4;
    const TELEFONE_OUTRO = 5;
    const EMAIL_PESSOAL = 6;
    const EMAIL_TRABALHO = 7;
    const EMAIL_OUTRO = 8;

    public $required = array('descontactsubtype', 'idcontacttype');
    protected $pk = "idcontactsubtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contactssubtypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contactssubtypes_save(?, ?, ?, ?);", array(
                $this->getidcontactsubtype(),
                $this->getdescontactsubtype(),
                $this->getidcontacttype(),
                $this->getiduser()
            ));

            return $this->getidcontactsubtype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("sp_contactssubtypes_remove", array(
            $this->getidcontactsubtype()
        ));

        return true;
        
    }

}

?>