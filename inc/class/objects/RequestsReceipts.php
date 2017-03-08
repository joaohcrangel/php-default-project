<?php

class RequestsReceipts extends Collection {

    protected $class = "RequestReceipt";
    protected $saveQuery = "sp_requestsreceipts_save";
    protected $saveArgs = array("idrequest", "desauthentication");
    protected $pk = "idrequest";
    public function get(){}

    public static function listAll(){

    	$requests = new RequestReceipt();

    	$requests->loadFromQuery("CALL sp_requestsreceipts_list();");

    	return $requests;

    }

}

?>