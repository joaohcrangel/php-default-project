

<?php

class PessoasDispositivos extends Collection {

    protected $class = "PessoaDispositivo";
    protected $saveQuery = "sp_pessoasdispositivos_save";
    protected $saveArgs = array("iddispositivo", "idpessoa", "desdispositivo", "desid", "dessistema");
    protected $pk = "iddispositivo";

    public function get(){}

}

?>