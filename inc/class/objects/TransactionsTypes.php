<?php

class TransactionsTypes extends Collection {

    protected $class = "TransactionType";
    protected $saveQuery = "sp_transactionstypes_save";
    protected $saveArgs = array("idtransactiontype", "destransactiontype", "dtregister");
    protected $pk = "idtransactiontype";

    public function get(){}

}

?>