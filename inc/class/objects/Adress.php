<?php

class Adress extends Model {

    const COMPLETE = 1;
    const SUMMARY = 2;

    public $required = array('idadress', 'idadresstype', 'desadress', 'desnumber', 'desdistrict', 'descity', 'desstate', 'descountry', 'descep');
    protected $pk = "idadress";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_adresses_get(".$args[0].");");
                
    }

    public function getFormattedCep(){

        $formatted = parent::toMask("#####-###", str_replace('-', '', $this->getdescep()));
        return $this->setdesformatedcep($formatted);

    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_adresses_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidadress(),
                $this->getidadresstype(),
                $this->getdesadress(),
                $this->getdesnumber(),
                $this->getdesdistrict(),
                $this->getdescity(),
                $this->getdesstate(),
                $this->getdescountry(),
                $this->getdescep(),
                $this->getdescomplement(),
                $this->getinmain()
            ));

            return $this->getidadress();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->exec("sp_adresses_remove", array(
            $this->getidadress()
        ));

        return true;
        
    }

    public function loadByNames(){

        $city = City::loadFromName($this->getdescity());

        $this->setArrayInAttr($city->getFields());

    }

    public static function getByCEP($descep):Adress
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

        $adress = new adress(array(
            'desadress'=>$data['logradouro'],
            'descomplement'=>$data['complement'],
            'desdistrict'=>$data['district'],
            'descity'=>$data['localidade'],
            'desstate'=>$state->getdesstate(),
            'desuf'=>$state->getdesuf(),
            'descountry'=>$state->getdescountry(),
            'descep'=>$data['cep']
        ));

        $adress->loadByNames();

        return $adress;

    }

    public function getToString($options = Adress::COMPLETE):string
    {

        $commas = array();

        switch ($options) {
            case Adress::COMPLETE:
            foreach (array(
                'desadress', 'desnumber', 'desdistrict', 'descity', 'desstate', 'descountry'
            ) as $field) {
                if ($this->{'get'.$field}()) array_push($commas, $this->{'get'.$field}());
            }
            break;
            case Adress::SUMMARY:
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

        return $this->getToString(Adress::COMPLETE);

    }

}

?>