<?php

class SiteContatos extends Collection {

    protected $class = "SiteContato";
    protected $saveQuery = "sp_sitecontatos_save";
    protected $saveArgs = array("idsitecontato", "idpessoa", "desmensagem", "inlido");
    protected $pk = "idsitecontato";
    public function get(){}

    public static function listAll(){

    	$contatos = new SiteContatos();

    	$contatos->loadFromQuery("CALL sp_sitecontatos_list();");

    	return $contatos;

    }

      public function getByPessoa(Pessoa $pessoa):SiteContatos
      
    {
    
         $this->loadFromQuery("CALL sp_sitecontatosfrompessoa_list(?)",array(
               $pessoa->getidpessoa()
               
        ));

         return $this;

    }


}

?>