<?php

namespace Hcode\Email;

use Hcode\Collection;

class Emails extends Collection {

    protected $class = "Hcode\Email\Email";
    protected $saveQuery = "sp_emails_save";
    protected $saveArgs = array("idemail", "desemail", "dessubject", "desbody", "desbcc", "descc", "desreplyto", "dtregister");
    protected $pk = "idemail";

    public function get(){}

}

?>