<?php
class Contatos extends Collection {

    protected $class = "Contato";
    protected $saveQuery = "sp_contatos_save";
    protected $saveArgs = array("idcontato", "idcontatotipo", "idcontatosubtipo", "idpessoa", "descontato", "inprincipal");
    protected $pk = "idcontato";

    public function get(){}

     public static function listAll():Pessoas
     {

     	$pessoas = new Pessoas();

    	$pessoas->loadFromQuery("call sp_contatos_list()");

    	return $pessoas;

    }
    
    public function getByPessoa(Pessoa $pessoa):Contatos
    {
    
         $this->loadFromQuery("CALL sp_contatosfrompessoa_list(?)",array(
               $pessoa->getidpessoa()
               
        ));

         return $this;

    }

    public static function listFromPessoa(Pessoa $pessoa):Contatos
    
    {

    	$contatos = new Contatos();

    	$contatos->loadFromQuery("CALL sp_contatosfrompessoa_list(?)", array(
    		$pessoa->getidpessoa()
    	));

    	return $contatos;

    }

}
?>