<?php
class Pessoa extends Model {

    public $required = array('despessoa', 'idpessoatipo');
    protected $pk = "idpessoa";

    public function get()
    {

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." nÃ£o informado");

        $this->queryToAttr("CALL sp_pessoas_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoas_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidpessoa(),
                $this->getdespessoa(),
                $this->getidpessoatipo(),
                $this->getdtnascimento(),
                $this->getdessexo(),
                $this->getdesfoto(),
                $this->getdesemail(),
                $this->getdesdestelefone(),
                $this->getdescpf(),
                $this->getdesrg(),
                $this->getdescnpj()
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

        $configs = Session::getConfiguracoes();
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        $filename = $uploadDir.$this->getdesfoto();

        if (file_exists(PATH.$filename) && is_file(PATH.$filename)) {
            return $this->setdesphotourl($filename);
        } else {

            $filename = "/res/img/";

            switch ($this->getidpessoatipo()) {
                case PessoaTipo::FISICA:

                   return $this->setdesphotourl("/res/img/".(($this->getdessexo()==='F')?'female':'male').".png");

                break;
                case PessoaTipo::JURIDICA:

                    return $this->setdesphotourl("/res/img/company.png");

                break;
            }

            
        }

    }
    public function getEndereco():Endereco
    {

        $data = array();

        foreach (array(
            'idenderecotipo', 'idendereco', 'desendereco',
            'desnumero', 'desbairro', 'descidade', 'desestado',
            'despais', 'descep', 'inprincipal', 'desenderecotipo'
        ) as $field) {
            $data[$field] = $this->{'get'.$field}();
        }

        return new Endereco($data);

    }

    public function getDocumento($iddocumentotipo):Documento
    {

        $data = array();

        switch ((int)$iddocumentotipo) {
            case DocumentoTipo::CPF:
            $data['desdocumento'] = $this->getdescpf();
            $data['iddocumento'] = $this->getidcpf();
            $data['iddocumentotipo'] = DocumentoTipo::CPF;
            break;

            case DocumentoTipo::CNPJ:
            $data['desdocumento'] = $this->getdescnpj();
            $data['iddocumento'] = $this->getidcnpj();
            $data['iddocumentotipo'] = DocumentoTipo::CNPJ;
            break;

            case DocumentoTipo::RG:
            $data['desdocumento'] = $this->getdesrg();
            $data['iddocumento'] = $this->getidrg();
            $data['iddocumentotipo'] = DocumentoTipo::RG;
            break;
        }

        return new Documento($data);

    }

    public function addArquivo(Arquivo $arquivo){

        $arquivo->setidpessoa($this->getidpessoa());

        $this->execute("CALL sp_pessoasarquivos_save(?, ?)", array(
            $arquivo->getidpessoa(),
            $arquivo->getidarquivo()
        ));

        return $arquivo;

    }

    public function setPhoto(Arquivo $foto){

        $this->addArquivo($foto);
        $this->setdesfoto($foto->getdesarquivo().'.'.$foto->getdesextensao());
        $this->save();

    }

    public function getFields(){

        $this->getPhotoURL();

        $endereco = $this->getEndereco();
        $endereco->setdesenderecoresumido($endereco->getToString(Endereco::SUMMARY));

        if ($this->getdescpf()) {
            $cpf = $this->getDocumento(DocumentoTipo::CPF);
            $cpf->getFormatted();
        } else {
            $cpf = new Documento();
        }

        if ($this->getdescnpj()) {
            $cnpj = $this->getDocumento(DocumentoTipo::CNPJ);
            $cnpj->getFormatted();
        } else {
            $cnpj = new Documento();
        }

        $data = parent::getFields();

        $data['cpf'] = $cpf->getFields();
        $data['cnpj'] = $cnpj->getFields();
        $data['endereco'] = $endereco->getFields();

        return $data;

    }

}

?>