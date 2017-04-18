<?php

namespace Hcode\Financial\Transaction;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Financial\Transaction\Type";
    protected $saveQuery = "sp_transactionstypes_save";
    protected $saveArgs = array("idtransactiontype", "destransactiontype", "dtregister");
    protected $pk = "idtransactiontype";

    public function get(){}

    public static function listAll():Types
    {
    	$transaction = new Types();

    	$transaction->loadFromQuery("Call sp_transactionstypes_list()");

    	return $transaction;
    }

}

?>