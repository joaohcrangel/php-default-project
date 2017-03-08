<?php

class FormsPayments extends Collection {

    protected $class = "FormPayment";
    protected $saveQuery = "sp_formspayments_save";
    protected $saveArgs = array("idformpayment", "idgateway", "desformpayment", "nrplotsmax", "instatus");
    protected $pk = "idformpayment";
    public function get(){}

    public static function listAll(){

    	$forms = new FormsPayments();

    	$forms->loadFromQuery("CALL sp_formspayments_list();");

    	return $forms;

    }

}

?>