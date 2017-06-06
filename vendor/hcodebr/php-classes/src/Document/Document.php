<?php

namespace Hcode\Document;

use Hcode\Model;
use Hcode\Exception;

class Document extends Model {

    public $required = array('iddocumenttype', 'idperson', 'desdocument');
    protected $pk = "iddocument";

    public function get()
    {

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_documents_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_documents_save(?, ?, ?, ?);", array(
                $this->getiddocument(),
                $this->getiddocumenttype(),
                $this->getidperson(),
                $this->getdesdocument()
            ));

            return $this->getiddocument();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_documents_remove", array(
            $this->getiddocument()
        ));

        return true;
        
    }

    public static function CPFValidate($cpf)
    {

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

    public static function CNPJValidate($cnpj)
    {
        if (strlen($cnpj) <> 14) return 0; 
        $sum1 = ($cnpj[0] * 5) + 
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
        $rest = $sum1 % 11; 
        $digit1 = $rest < 2 ? 0 : 11 - $rest; 
        $sum2 = ($cnpj[0] * 6) + 
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
        $rest = $sum2 % 11; 
        $digit2 = $rest < 2 ? 0 : 11 - $rest; 
        return (($cnpj[12] == $digit1) && ($cnpj[13] == $digit2));
    }

    public function getFormatted()
    {

        switch ($this->getiddocumenttype()) {
            case Type::CPF:
            $formatted = parent::toMask("###.###.###-##", $this->getdesdocument());
            break;
            case Type::CNPJ:
            $formatted = parent::toMask("##.###.###/####-##", $this->getdesdocument());
            break;
            case Type::RG:
            $formatted = parent::toMask("##.###.###/##", $this->getdesdocument());
            break;
        }

        return $this->setdesdocumentformated($formatted);

    }

    public function __toString()
    {

        return $this->getFormatted();

    }

    public static function exists($desdocument, $type)
    {

        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_documents WHERE desdocument = ? AND iddocumenttype = ?", [
            $desdocument,
            $type
        ]);

        return ($result['iddocument'] > 0)?new Document($result):false;

    }

}

?>