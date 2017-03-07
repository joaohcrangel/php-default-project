


<?php

class LogsTypes extends Collection {

    protected $class = "LogType";
    protected $saveQuery = "sp_logstypes_save";
    protected $saveArgs = array("idlogtype", "deslogtype", "dtregister");
    protected $pk = "idlogtype";

    public function get(){}

}

?>