<?php

namespace Hcode;

class EmailsAttachments extends Collection {

    protected $class = "Hcode\EmailAttachment";
    protected $saveQuery = "sp_emailsattachments_save";
    protected $saveArgs = array("idemail", "idfile", "dtregister");
    protected $pk = array(idemail, idfile);

    public function get(){}

}

?>