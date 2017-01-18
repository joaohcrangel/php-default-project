<?php

class Pessoa extends Model {

    public $required = array('despessoa', 'idpessoatipo');
    protected $pk = "idpessoa";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pessoas_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoas_save(?, ?, ?);", array(
                $this->getidpessoa(),
                $this->getdespessoa(),
                $this->getidpessoatipo()
            ));

            return $this->getidpessoa();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pessoas_remove(".$this->getidpessoa().")");

        return true;
        
    }

    public function getDocumentos(){

        $documentos = new Pessoas();

        $documentos->loadFromQuery("CALL sp_documentosfrompessoa_list(?);", array(
            $this->getidpessoa()
        ));

        return $documentos;

    }

    public function getContatos(){

        $contatos = new Pessoas();

        $contatos->loadFromQuery("CALL sp_contatosfrompessoa_list(?);", array(
            $this->getidpessoa()
        ));

        return $contatos;

    }

    public function getSiteContatos(){

        $col = new Pessoas();

        $col->loadFromQuery("CALL sp_sitecontatosfrompessoa_list(?);", array(
            $this->getidpessoa()
        ));

        return $col;

    }

    public function getPagamentos(){

        $pagamentos = new Pessoas();

        $pagamentos->loadFromQuery("CALL sp_pagamentosfrompessoa_list(?);", array(
            $this->getidpessoa()
        ));

        return $pagamentos;

    }

    public function getCartoes(){

        $cartoes = new Pessoas();

        $cartoes->loadFromQuery("CALL sp_cartoesfrompessoa_list(?);", array(
            $this->getidpessoa()
        ));

        return $cartoes;

    }

    public function getCarrinhos(){

        $carrinhos = new Pessoas();

        $carrinhos->loadFromQuery("CALL sp_carrinhosfrompessoa_list(?);", array(
            $this->getidpessoa()
        ));

        return $carrinhos;

    }

    public function getEnderecos(){

        $enderecos = new Pessoas();

        $enderecos->loadFromQuery("CALL sp_enderecosfrompessoa_list(?);", array(
            $this->getidpessoa()
        ));

        return $enderecos;

    }

}

?>