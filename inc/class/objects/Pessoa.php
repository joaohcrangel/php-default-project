<?php

class Pessoa extends Model {

    public $required = array('despessoa', 'idpessoatipo');
    protected $pk = "idpessoa";

    public function get()
    {

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pessoas_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoas_save(?, ?, ?);", array(
                $this->getidpessoa(),
                $this->getdespessoa(),
                $this->getidpessoatipo()
            ));

            return $this->getidpessoa();

        }else{

            return null;

        }
        
    }

    public function remove():bool
    {

        $this->execute("CALL sp_pessoas_remove(".$this->getidpessoa().")");

        return true;
        
    }
    public function getContatos():Contatos
    {

        return new Contatos($this);

    }

    public function getHistoricos():PessoasHistoricos
    {

        return new PessoasHistoricos($this);

    }

    public function getDocumentos():Documentos
    {

        return new Documentos($this);

    }

    public function getSiteContatos():SiteContatos
    {

        return new SiteContatos($this);

    }

    public function getPagamentos():Pagamentos
    {
        return new Pagamentos($this);
    }
   

    public function getCartoesCreditos():CartoesCreditos
    {

        return new CartoesCreditos($this);   

    }

    public function getCarrinhos():Carrinhos
    {

        return new Carrinhos($this);    

    }

    public function getEnderecos():Enderecos
    {

        return new Enderecos($this);  

    }

}

?>