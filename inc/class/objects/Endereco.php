<?php

class Endereco extends Model {

    const COMPLETE = 1;
    const SUMMARY = 2;

    public $required = array('idenderecotipo', 'desendereco', 'desnumero', 'desbairro', 'descidade', 'desestado', 'despais', 'descep', 'inprincipal');
    protected $pk = "idendereco";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_enderecos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_enderecos_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidendereco(),
                $this->getidenderecotipo(),
                $this->getdesendereco(),
                $this->getdesnumero(),
                $this->getdesbairro(),
                $this->getdescidade(),
                $this->getdesestado(),
                $this->getdespais(),
                $this->getdescep(),
                $this->getdescomplemento(),
                $this->getinprincipal()
            ));

            return $this->getidendereco();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_enderecos_remove(".$this->getidendereco().")");

        return true;
        
    }

    public function loadByNames(){

        $cidade = Cidade::loadFromName($this->getdescidade());

        $this->setArrayInAttr($cidade->getFields());

    }

    public static function getByCEP($descep):Endereco
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

        $estado = Estado::loadFromUf($data['uf']);

        $endereco = new Endereco(array(
            'desendereco'=>$data['logradouro'],
            'descomplemento'=>$data['complemento'],
            'desbairro'=>$data['bairro'],
            'descidade'=>$data['localidade'],
            'desestado'=>$estado->getdesestado(),
            'desuf'=>$estado->getdesuf(),
            'despais'=>$estado->getdespais(),
            'descep'=>$data['cep']
        ));

        $endereco->loadByNames();

        return $endereco;

    }

    public function getToString($options = Endereco::COMPLETE):string
    {

        $virgulas = array();

        switch ($options) {
            case Endereco::COMPLETE:
            foreach (array(
                'desendereco', 'desnumero', 'desbairro', 'descidade', 'desestado', 'despais'
            ) as $field) {
                if ($this->{'get'.$field}()) array_push($virgulas, $this->{'get'.$field}());
            }
            break;
            case Endereco::SUMMARY:
            foreach (array(
                'descidade', 'desestado', 'despais'
            ) as $field) {
                if ($this->{'get'.$field}()) array_push($virgulas, $this->{'get'.$field}());
            }
            break;
            break;
        }

        return implode(', ', $virgulas);

    }

    public function __toString(){

        return $this->getToString(Endereco::COMPLETE);

    }

}

?>