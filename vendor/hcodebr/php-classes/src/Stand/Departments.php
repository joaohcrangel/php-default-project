<?php

class Departments extends Collection {

    protected $class = "Department";
    protected $saveQuery = "sp_departments_save";
    protected $saveArgs = array("iddepartment", "iddepartmentparent", "desdepartment", "dtregister");
    protected $pk = "iddepartment";

    public function get(){}

}

?>