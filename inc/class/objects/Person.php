<?php

class Person extends Model {

    public $required = array('idpersontype', 'desperson');
    protected $pk = "idperson";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_persons_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_persons_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidperson(),
                $this->getdesperson(),
                $this->getidpersontype(),                
                $this->getdtbirth(),
                $this->getdessex(),
                $this->getdesphoto(),
                $this->getdesemail(),
                $this->getdesphone(),
                $this->getdescpf(),
                $this->getdesrg(),
                $this->getdescnpj()
            ));

            return $this->getidperson();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("sp_persons_remove", array(
            $this->getidperson()
        ));

        return true;
        
    }

    public function getContacts():Contacts
    {

        return new Contacts($this);

    }

    public function getLogs():PersonsLogs
    {

        return new PersonsLogs($this);

    }

    public function getDocuments():Documents
    {

        return new Documents($this);

    }

    public function getSiteContacts():SiteContacts
    {

        return new SiteContacts($this);

    }

    public function getOrders():Orders
    {
        return new Orders($this);
    }
   

    public function getCreditCards():CreditCards
    {

        return new CreditCards($this);   

    }

    public function getCarts():Carts
    {

        return new Carts($this);    

    }

    public function getAddresses():Addresses
    {

        return new Addresses($this);  

    }

    public function getUsers():Users
    {
        return new Users($this);
    }

    public function addContact($descontact, $idcontactsubtype):Contact
    {

        $contact = new Contact(array(
            'idcontactsubtype'=>(int)$idcontactsubtype,
            'idperson'=>$this->getidperson(),
            'descontact'=>$descontact,
            'inmain'=>true
        ));

        $contact->save();

        return $contact;

    }

    public function addEmail($desemail):Contact
    {

        return $this->addContact($desemail, ContactSubType::EMAIL_OTHER);

    }

    public function addPhone($desphone):Contact
    {

        return $this->addContact($destelefone, ContactSubType::PHONE_OTHER);

    }

    public function addDocument($desdocument, $iddocumenttype):Document
    {

        $document = new Document(array(
            'idperson'=>$this->getidperson(),
            'iddocumentotype'=>(int)$iddocumenttype,
            'desdocument'=>$desdocument
        ));

        $document->save();

        return $document;

    }

    public function addCPF($descpf):Document
    {

        return $this->addDocument($descpf, DocumentType::CPF);

    }

    public function addCNPJ($descnpj):Document
    {

        return $this->addDocument($descnpj, DocumentType::CNPJ);

    }

    public function addAddress(Address $address):Address
    {

        $address->setidperson($this->getidperson());

        $this->execute("CALL sp_personsaddresses_save(?, ?)", array(
            $address->getidperson(),
            $address->getidaddress()
        ));

        return $address;

    }

    public function getPhotoURL():string
    {

        $configs = Session::getConfigurations();
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        $filename = $uploadDir.$this->getdesphoto();

        if (file_exists(PATH.$filename) && is_file(PATH.$filename)) {
            return $this->setdesphotourl($filename);
        } else {

            $filename = "/res/img/";

            switch ($this->getidpersontype()) {
                case PersonType::FISICA:

                   return $this->setdesphotourl("/res/img/".(($this->getdessex()==='F')?'female':'male').".png");

                break;
                case PersonType::JURIDICA:

                    return $this->setdesphotourl("/res/img/company.png");

                break;
            }

            
        }

    }
    public function getAddress():Address
    {

        $data = array();

        foreach (array(
            'idaddresstype', 'idaddress', 'desaddress',
            'desnumber', 'desdistrict', 'descity', 'desstate',
            'descountry', 'descep', 'inmain', 'desaddresstype'
        ) as $field) {
            $data[$field] = $this->{'get'.$field}();
        }

        return new Address($data);

    }

    public function getDocument($iddocumenttype):Document
    {

        $data = array();

        switch ((int)$iddocumenttype) {
            case DocumentType::CPF:
            $data['desdocument'] = $this->getdescpf();
            $data['iddocument'] = $this->getidcpf();
            $data['iddocumenttype'] = DocumentType::CPF;
            break;

            case DocumentType::CNPJ:
            $data['desdocument'] = $this->getdescnpj();
            $data['iddocument'] = $this->getidcnpj();
            $data['iddocumenttype'] = DocumentType::CNPJ;
            break;

            case DocumentType::RG:
            $data['desdocument'] = $this->getdesrg();
            $data['iddocument'] = $this->getidrg();
            $data['iddocumenttype'] = DocumentType::RG;
            break;
        }

        return new Document($data);

    }

    public function addArquivo(Arquivo $arquivo){

        $arquivo->setidperson($this->getidperson());

        $this->execute("CALL sp_personsarquivos_save(?, ?)", array(
            $arquivo->getidperson(),
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

        $address = $this->getAddress();

        $address->setdesaddressresumido($address->getToString(Address::SUMMARY));

        if ($this->getdescpf()) {
            $cpf = $this->getDocument(DocumentType::CPF);
            $cpf->getFormatted();
        } else {
            $cpf = new Document();
        }

        if ($this->getdescnpj()) {
            $cnpj = $this->getDocument(DocumentType::CNPJ);
            $cnpj->getFormatted();
        } else {
            $cnpj = new Document();
        }

        $data = parent::getFields();

        $data['cpf'] = $cpf->getFields();
        $data['cnpj'] = $cnpj->getFields();
        $data['address'] = $address->getFields();

        return $data;

    }

}

?>