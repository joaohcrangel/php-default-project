

<?php

class PessoasValoresCampos extends Collection {

    protected $class = "PessoaValorCampo";
    protected $saveQuery = "sp_pessoasvalorescampos_save";
    protected $saveArgs = array("idcampo", "descampo");
    protected $pk = "idcampo";

    public function get(){}

     public static function listAll(){

		$pessoavalor = new PessoasValoresCampos();

		$pessoavalor->loadFromQuery("select * from tb_pessoasvalorescampos");

    	return $pessoavalor;

    }

}

?>