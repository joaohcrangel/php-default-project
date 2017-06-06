<?php

namespace Hcode\Person;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Session;
use Hcode\Contact\Contact;
use Hcode\Contact\Contacts;
use Hcode\Contact\Subtype;
use Hcode\Document\Document;
use Hcode\Document\Documents;
use Hcode\Financial\Order\Orders;
use Hcode\Financial\CreditCards;
use Hcode\Shop\Carts;
use Hcode\Address\Address;
use Hcode\Address\Addresses;
use Hcode\System\Users;
use Hcode\FileSystem\File;
use Hcode\Person\Type;
use Hcode\Site\Contacts as SiteContacts;

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

        $this->proc("sp_persons_remove", array(
            $this->getidperson()
        ));

        return true;
        
    }

    public function getContacts():Contacts
    {

        return new Contacts($this);

    }

    public function getLogs():Logs
    {

        return new Logs($this);

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

    public function getCategories():Category\Types
    {
        return new Category\Types($this);
    }

    public function removeCategories():bool
    {

        $this->proc("sp_categoriesfromperson_remove", array(
            $this->getidperson()
        ));

        return true;

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

        return $this->addContact($desemail, Subtype::EMAIL_OTHER);

    }

    public function addPhone($desphone):Contact
    {

        return $this->addContact($destelefone, Subtype::PHONE_OTHER);

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

        return $this->addDocument($descpf, \Hcode\Document\Type::CPF);

    }

    public function addCNPJ($descnpj):Document
    {

        return $this->addDocument($descnpj, \Hcode\Document\Type::CNPJ);

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

    public function addCategory(\Hcode\Person\Category\Type $category):\Hcode\Person\Category\Type
    {

        $this->execute("CALL sp_personscategories_save(?, ?);", array(
            $this->getidperson(),
            $category->getidcategory()
        ));

        return $category;

    }

    public function getPhotoURL()
    {

        $configs = Session::getConfigurations();
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        $filename = $uploadDir.$this->getdesphoto();

        if (file_exists(PATH.$filename) && is_file(PATH.$filename)) {
            return $this->setdesphotourl($filename);
        } else {

            $filename = "/res/img/";

            switch ($this->getidpersontype()) {
                case Type::FISICA:

                   return $this->setdesphotourl("/res/img/".(($this->getdessex()==='F')?'female':'male').".png");

                break;
                case Type::JURIDICA:

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
            case \Hcode\Document\Type::CPF:
            $data['desdocument'] = $this->getdescpf();
            $data['iddocument'] = $this->getidcpf();
            $data['iddocumenttype'] = \Hcode\Document\Type::CPF;
            break;

            case \Hcode\Document\Type::CNPJ:
            $data['desdocument'] = $this->getdescnpj();
            $data['iddocument'] = $this->getidcnpj();
            $data['iddocumenttype'] = \Hcode\Document\Type::CNPJ;
            break;

            case \Hcode\Document\Type::RG:
            $data['desdocument'] = $this->getdesrg();
            $data['iddocument'] = $this->getidrg();
            $data['iddocumenttype'] = \Hcode\Document\Type::RG;
            break;
        }

        return new Document($data);

    }

    public function addFile(File $file){

        $file->setidperson($this->getidperson());

        $this->execute("CALL sp_personsfiles_save(?, ?)", array(
            $file->getidperson(),
            $file->getidfile()
        ));

        return $file;

    }

    public function setPhoto(File $photo){

        $this->addFile($photo);
        $this->setdesphoto($photo->getdesfile().'.'.$photo->getdesextension());
        $this->save();

    }

    public static function getByEmail($desemail):Person
    {

        $person = new Person();

        $person->queryToAttr("CALL sp_personsbyemail_get(?);", array(
            $desemail
        ));

        return $person;

    }

    public function getFields(){

        $this->getPhotoURL();

        $address = $this->getAddress();

        $address->setdesaddressresumido($address->getToString(Address::SUMMARY));

        if ($this->getdescpf()) {
            $cpf = $this->getDocument(\Hcode\Document\Type::CPF);
            $cpf->getFormatted();
        } else {
            $cpf = new \Hcode\Document\Document();
        }

        if ($this->getdescnpj()) {
            $cnpj = $this->getDocument(\Hcode\Document\Type::CNPJ);
            $cnpj->getFormatted();
        } else {
            $cnpj = new \Hcode\Document\Document();
        }

        $data = parent::getFields();

        $data['cpf'] = $cpf->getFields();
        $data['cnpj'] = $cnpj->getFields();
        $data['address'] = $address->getFields();

        return $data;

    }

    public static function getSiteContactsHTML(Hcode\Site\Contact $siteContactFather, Hcode\Site\Contacts $sitesContactsAll){

        $roots = $sitesContactsAll->filter('idsitecontactfather', $siteContactFather->getidsitecontact());

        $html = '';

        if($roots->getSize() > 0){

            if($siteContactFather->getidsitecontact() === 0){
                $html = '<ol class="commentlist clearfix">';
                $html .= '<li class="comment even thread-even">';
            }else{
                $html = '<ul class="children">';
                $html .= '<li class="comment byuser comment-author-_smcl_admin odd alt" style>';
            }

            foreach ($roots->getItens() as $siteContact) {
                $html .= '
                    <div class="comment-wrap clearfix">

                        <div class="comment-meta">

                            <div class="comment-author vcard">

                                <span class="comment-avatar clearfix">
                                <img alt="" src="http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60" class="avatar avatar-60 photo avatar-default" height="60" width="60" /></span>
                            </div>

                        </div>

                        '.(($siteContactFather->getidsitecontact() === 0) ? '<div class="comment-content clearfix">' : '<div class="comment-content clearfix" style="padding: 0 0 0 30px;">').'

                            <div class="comment-author">'.$siteContact->getdesperson().'<span><a href="#">'.$siteContact->getdesdtregister().'</a></span></div>

                                <p>'.$siteContact->getdesmessage().'</p>

                                <a class="comment-reply-link" href="#""><i class="icon-reply"></i></a>

                            </div>

                            <div class="clear"></div>

                        </div>

                        '.(($siteContact->getnrsubcomments() > 0) ? Person::getSiteContactsHTML($siteContact, $sitesContactsAll) : '').'
                    </div>
                ';

                $html .= '</li>';

                unset($siteContact);

            }

            if($siteContactFather->getidsitecontact() === 0){
                $html .= '</ol>';
            }else{
                $html .= '</ul>';
            }               

        }

        return $html;

    }

}

?>