<?php

namespace Hcode\Financial;

use Hcode\Model;
use Hcode\Exception;

class FormPayment extends Model {

    public $required = array('idformpayment', 'idgateway', 'desformpayment', 'nrparcelsmax');
    protected $pk = "idformpayment";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_formspayments_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_formspayments_save(?, ?, ?, ?, ?);", array(
                $this->getidformpayment(),
                $this->getidgateway(),
                $this->getdesformpayment(),
                $this->getnrparcelsmax(),
                $this->getinstatus()
            ));

            return $this->getidformpayment();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_formspayments_remove", array(
            $this->getidformpayment()
        ));

        return true;
        
    }

}

?>