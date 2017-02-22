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

            $this->queryToAttr("CALL sp_pessoas_save(?, ?, ?, ?, ?);", array(
                $this->getidpessoa(),
                $this->getdespessoa(),
                $this->getidpessoatipo(),
                $this->getdtnascimento(),
                $this->getdessexo()
            ));

            return $this->getidpessoa();

        }else{

            return 0;

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

    public function getPedidos():Pedidos
    {
        return new Pedidos($this);
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

    public function getUsuarios():Usuarios
    {
        return new Usuarios($this);
    }

    public function addContato($descontato, $idcontatosubtipo):Contato
    {

        $contato = new Contato(array(
            'idcontatosubtipo'=>(int)$idcontatosubtipo,
            'idpessoa'=>$this->getidpessoa(),
            'descontato'=>$descontato,
            'inprincipal'=>true
        ));

        $contato->save();

        return $contato;

    }

    public function addEmail($desemail):Contato
    {

        return $this->addContato($desemail, ContatoSubtipo::EMAIL_OUTRO);

    }

    public function addTelefone($destelefone):Contato
    {

        return $this->addContato($destelefone, ContatoSubtipo::TELEFONE_OUTRO);

    }

    public function addDocumento($desdocumento, $iddocumentotipo):Documento
    {

        $documento = new Documento(array(
            'idpessoa'=>$this->getidpessoa(),
            'iddocumentotipo'=>(int)$iddocumentotipo,
            'desdocumento'=>$desdocumento
        ));

        $documento->save();

        return $documento;

    }

    public function addCPF($descpf):Documento
    {

        return $this->addDocumento($descpf, DocumentoTipo::CPF);

    }

    public function addCNPJ($descnpj):Documento
    {

        return $this->addDocumento($descnpj, DocumentoTipo::CNPJ);

    }

    public function addEndereco(Endereco $endereco):Endereco
    {

        $endereco->setidpessoa($this->getidpessoa());

        $this->execute("CALL sp_pessoasenderecos_save(?, ?)", array(
            $endereco->getidpessoa(),
            $endereco->getidendereco()
        ));

        return $endereco;

    }

    public function getPhotoURL():string
    {

        $uploadDir = $configs->getByName('UPLOAD_DIR');

        $filename = PATH.$uploadDir.$this->getdesfoto();

        if (file_exists($filename)) {
            return $filename;
        } else {
            $filename = PATH."/res/img/";

            switch ($this->getidpessoatipo()) {
                case PessoaTipo::FISICA:

                   return $this->setdesphotourl(PATH."/res/img/".(($this->getdessexo()==='F')?'female':'male').".png");

                break;
                case PessoaTipo::JURIDICA:

                    return $this->setdesphotourl(PATH."/res/img/company.png");

                break;
            }

            
        }

    }

}

?>