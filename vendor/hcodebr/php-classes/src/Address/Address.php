<?php

namespace Hcode\Address;

use Hcode\Model;
use Hcode\Exception;

class Address extends Model {

    const COMPLETE = 1;
    const SUMMARY = 2;

    public $required = array('idaddresstype', 'desaddress', 'desnumber', 'desdistrict', 'descity', 'desstate', 'descountry', 'descep');
    protected $pk = "idaddress";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_addresses_get(".$args[0].");");
                
    }

    public function getFormattedCep(){

        $formatted = parent::toMask("#####-###", str_replace('-', '', $this->getdescep()));
        return $this->setdesformatedcep($formatted);

    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_addresses_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidaddress(),
                $this->getidaddresstype(),
                $this->getdesaddress(),
                $this->getdesnumber(),
                $this->getdesdistrict(),
                $this->getdescity(),
                $this->getdesstate(),
                $this->getdescountry(),
                $this->getdescep(),
                $this->getdescomplement(),
                $this->getinmain()
            ));

            return $this->getidaddress();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_addresses_remove", array(
            $this->getidaddress()
        ));

        return true;
        
    }

    public function loadByNames(){

        $city = City::loadFromName($this->getdescity());

        $this->setArrayInAttr($city->getFields());

    }

    public static function getByCEP($descep):Address
    {

        preg_match_all('!\d+!', $descep, $nrcep);

        $nrcep = $nrcep[0][0];

        if (strlen($nrcep)!==8) {

            throw new Exception("O CEP $descep não é válido.", 400);            

        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://viacep.com.br/ws/$nrcep/json/");

        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
        // Get the response and close the channel.
        $data = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (!isset($data['uf'])) {
            throw new Exception("Cep não encontrado.", 404);
        }

        $state = State::loadFromUf($data['uf']);

        $address = new Address(array(
            'desaddress'=>$data['logradouro'],
            'descomplement'=>$data['complemento'],
            'desdistrict'=>$data['bairro'],
            'descity'=>$data['localidade'],
            'desstate'=>$state->getdesstate(),
            'desuf'=>$state->getdesuf(),
            'descountry'=>$state->getdescountry(),
            'descep'=>$data['cep']
        ));

        $address->loadByNames();

        return $address;

    }

    public function getToString($options = Address::COMPLETE):string
    {

        $commas = array();

        switch ($options) {
            case Address::COMPLETE:
            foreach (array(
                'desaddress', 'desnumber', 'desdistrict', 'descity', 'desstate', 'descountry'
            ) as $field) {
                if ($this->{'get'.$field}()) array_push($commas, $this->{'get'.$field}());
            }
            break;
            case Address::SUMMARY:
            foreach (array(
                'descity', 'desstate', 'descountry'
            ) as $field) {
                if ($this->{'get'.$field}()) array_push($commas, $this->{'get'.$field}());
            }
            break;
            break;
        }

        return implode(', ', $commas);

    }

    public function getFields(){

        $this->getFormattedCep();

        return parent::getFields(); 

    }

    public function __toString(){

        return $this->getToString(Address::COMPLETE);

    }

}

?>