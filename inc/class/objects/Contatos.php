<?php
class Contatos extends Collection {
    protected $class = "Contato";
    protected $saveQuery = "sp_contatos_save";
    protected $saveArgs = array("idcontato", "idcontatotipo", "idcontatosubtipo", "idpessoa", "descontato", "inprincipal");
    protected $pk = "idcontato";
    public function get(){}
}
?>