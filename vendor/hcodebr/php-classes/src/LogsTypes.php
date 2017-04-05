<?php

namespace Hcode;

class LogsTypes extends Collection {

    protected $class = "Hcode\LogType";
    protected $saveQuery = "sp_logstypes_save";
    protected $saveArgs = array("idlogtype", "deslogtype");
    protected $pk = "idlogtype";

    public function get(){}

    public static function listAll():LogsTypes
    {

		$logstypes = new LogsTypes();

		$logstypes->loadFromQuery("SELECT * FROM tb_logstypes;");

    	return $logstypes;

    }

}

?>