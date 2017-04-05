<?php

namespace Hcode;

class TransactionsTypes extends Collection {

    protected $class = "Hcode\TransactionType";
    protected $saveQuery = "sp_transactionstypes_save";
    protected $saveArgs = array("idtransactiontype", "destransactiontype", "dtregister");
    protected $pk = "idtransactiontype";

    public function get(){}

    public static function listAll():TransactionsTypes
    {
    	$transaction = new TransactionsTypes();

    	$transaction->loadFromQuery("Call sp_transactionstypes_list()");

    	return $transaction;
    }

}

?>