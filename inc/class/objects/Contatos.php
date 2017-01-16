<?php

class Contatos extends Collection {

    protected $class = "Contato";
    protected $saveQuery = "sp_contatos_save";
    protected $saveArgs = array("idcontato", "idcontatotipo", "idcontatosubtipo", "idpessoa", "descontato", "inprincipal");
    protected $pk = "idcontato";

    public function get(){}

     public static function listAll(){

     	$pessoas = new Pessoas();

    	$pessoass->loadFromQuery("call sp_contatos_list()");

    	return $Pessoas;

    }
    
    public function getByPessoa(Pessoa $pessoa){
    
         $this->loadFromQuery("CALL sp_contatosfrompessoa_list(?)",array(
               $pessoa->getidpessoa()
               
            ));

         return $this;

     }

}

?>