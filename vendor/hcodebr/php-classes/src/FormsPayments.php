<?php

namespace Hcode;

class FormsPayments extends Collection {

    protected $class = "Hcode\FormPayment";
    protected $saveQuery = "sp_formspayments_save";
    protected $saveArgs = array("idformpayment", "idgateway", "desformpayment", "nrparcelsmax", "instatus");
    protected $pk = "idformpayment";
    public function get(){}

    public static function listAll(){

    	$forms = new FormsPayments();

    	$forms->loadFromQuery("CALL sp_formspayments_list();");

    	return $forms;

    }

}

?>