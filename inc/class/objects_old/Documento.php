<?php

class Documento extends Model {

    public $required = array('iddocumentotipo', 'idpessoa', 'desdocumento');
    protected $pk = "iddocumento";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_documentos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_documentos_save(?, ?, ?, ?);", array(
                $this->getiddocumento(),
                $this->getiddocumentotipo(),
                $this->getidpessoa(),
                $this->getdesdocumento()
            ));

            return $this->getiddocumento();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_documentos_remove(".$this->getiddocumento().")");

        return true;
        
    }

    public static function validaCPF($cpf){

        $result = '';
        for($i=0; $i<strlen($cpf); $i++){           
            $l = substr($cpf, $i, 1);
            if(is_numeric($l)) $result .= $l;
        }
        $cpf = $result;

        $arrCpf = array('00000000000','11111111111','22222222222','33333333333','44444444444','55555555555','66666666666','77777777777','88888888888','99999999999');
        if (strlen($cpf) != 11 || in_array($cpf,$arrCpf)){
            return false;
        }else{   // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
    
                $d = ((10 * $d) % 11) % 10;
    
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
    
            return true;
        }

    }

    public static function validaCNPJ($cnpj){
        if (strlen($cnpj) <> 14) return 0; 
        $soma1 = ($cnpj[0] * 5) + 
        ($cnpj[1] * 4) + 
        ($cnpj[2] * 3) + 
        ($cnpj[3] * 2) + 
        ($cnpj[4] * 9) + 
        ($cnpj[5] * 8) + 
        ($cnpj[6] * 7) + 
        ($cnpj[7] * 6) + 
        ($cnpj[8] * 5) + 
        ($cnpj[9] * 4) + 
        ($cnpj[10] * 3) + 
        ($cnpj[11] * 2); 
        $resto = $soma1 % 11; 
        $digito1 = $resto < 2 ? 0 : 11 - $resto; 
        $soma2 = ($cnpj[0] * 6) + 
        ($cnpj[1] * 5) + 
        ($cnpj[2] * 4) + 
        ($cnpj[3] * 3) + 
        ($cnpj[4] * 2) + 
        ($cnpj[5] * 9) + 
        ($cnpj[6] * 8) + 
        ($cnpj[7] * 7) + 
        ($cnpj[8] * 6) + 
        ($cnpj[9] * 5) + 
        ($cnpj[10] * 4) + 
        ($cnpj[11] * 3) + 
        ($cnpj[12] * 2); 
        $resto = $soma2 % 11; 
        $digito2 = $resto < 2 ? 0 : 11 - $resto; 
        return (($cnpj[12] == $digito1) && ($cnpj[13] == $digito2));
    }

    public function getFormatted(){

        switch ($this->getiddocumentotipo()) {
            case DocumentoTipo::CPF:
            $formatted = parent::toMask("###.###.###-##", $this->getdesdocumento());
            break;
            case DocumentoTipo::CNPJ:
            $formatted = parent::toMask("##.###.###/####-##", $this->getdesdocumento());
            break;
            case DocumentoTipo::RG:
            $formatted = parent::toMask("##.###.###/##", $this->getdesdocumento());
            break;
        }

        return $this->setdesdocumentoformatado($formatted);

    }

    public function __toString(){

        return $this->getFormatted();

    }

}

?>