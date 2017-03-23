<?php

class ProdutosPrecos extends Collection {

    protected $class = "ProdutoPreco";
    protected $saveQuery = "CALL sp_produtosprecos_save(?, ?, ?, ?, ?);";
    protected $saveArgs = array("idpreco", "idproduto", "dtinicio", "dttermino", "vlpreco");
    protected $pk = "idproduto";

    public function get(){}

}
?>