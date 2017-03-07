<?php

class Product extends Model {

    public $required = array('idproduct', 'idproducttype', 'desproduct', 'inremoved');
    protected $pk = "idproduct";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_products_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_products_save(?, ?, ?, ?, ?);", array(
                $this->getidproduct(),
                $this->getidproducttype(),
                $this->getdesproduct(),
                $this->getinremoved(),
                $this->getdtregister()
            ));

            return $this->getidproduct();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("sp_products_remove", array(
            $this->getidproduct()
        ));

        return true;
        
    }

    public function getCarts(){

        $carts = new Produtos();

        $carts->loadFromQuery("CALL sp_cartsfromproduto_list(?);", array(
            $this->getidproduto()
        ));

        return $carts;

    }

    public function getPedidos(){

        $pagamentos = new Produtos();

        $pagamentos->loadFromQuery("CALL sp_pagamentosfromproduto_list(?);", array(
            $this->getidproduto()
        ));

        return $pagamentos;

    }

    public function getProdutosPrecos(){

        $precos = new ProdutosPrecos();

        $precos->loadFromQuery("CALL sp_precosfromproduto_list(?);", array(
            $this->getidproduto()
        ));

        return $precos;

    }

    public function getArquivos():Arquivos
    {

        $arquivos = new Arquivos();

        $arquivos->loadFromQuery("
            SELECT * 
            FROM tb_arquivos a
            INNER JOIN tb_produtosarquivos b ON a.idarquivo = b.idarquivo
            WHERE b.idproduto = ?
        ", array(
            $this->getidproduto()
        ));

        return $arquivos;

    }

    public function addArquivo(Arquivo $arquivo):bool
    {

        $this->execute("
            INSERT INTO tb_produtosarquivos (idproduto, idarquivo)
            VALUES(?, ?);
        ", array(
            $this->getidproduto(),
            $arquivo->getidarquivo()
        ));

        return true;

    }

}

?>