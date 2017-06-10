


<?php

class Workersroleslogs extends Collection {

    protected $class = "Workersroleslog";
    protected $saveQuery = "sp_workersroleslogs_save";
    protected $saveArgs = array("idhistory", "idworker", "idrole", "vlsalary", "dtstart", "dtend", "dtregister");
    protected $pk = "idhistory";

    public function get(){}

}

?>