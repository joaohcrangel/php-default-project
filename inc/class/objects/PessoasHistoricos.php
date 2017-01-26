<?php

class PessoasHistoricos extends Collection {

    protected $class = "PessoaHistorico";
    protected $saveQuery = "sp_pessoashistoricos_save";
    protected $saveArgs = array("idpessoahistorico", "idpessoa", "idhistoricotipo", "deshistoricotipo");
    protected $pk = "idpessoahistorico";

    public function get(){}

     public function getByPessoa(Pessoa $pessoa){
    
         $this->loadFromQuery("CALL sp_pessoashistoricos_list(?)",array(
               $pessoa->getidpessoa()
               
            ));

         return $this;

     }

}

?>