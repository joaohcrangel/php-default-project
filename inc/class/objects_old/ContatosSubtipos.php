<?php

class ContatosSubtipos extends Collection {

    protected $class = "ContatoSubtipo";
    protected $saveQuery = "sp_contatossubtipos_save";
    protected $saveArgs = array("idcontatosubtipo", "idcontatotipo", "descontatosubtipo", "idusuario");
    protected $pk = "idcontatosubtipo";


    public function get(){}

    public static function listAll(){
      $col = new  ContatosSubtipos();
      $col->loadFromQuery("call sp_contatossubtipos_list()");
      return $col;

    }

    
}

?>