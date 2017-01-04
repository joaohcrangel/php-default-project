<?php
class ContatosSubtipos extends Collection {
    protected $class = "ContatoSubtipo";
    protected $saveQuery = "sp_contatossubtipos_save";
    protected $saveArgs = array("idcontatosubtipo", "idcontatotipo", "descontatosubtipo", "idusuario");
    protected $pk = "idcontatosubtipo";
    public function get(){}
}
?>