
<?php

class EmailsAttachments extends Collection {

    protected $class = "EmailAttachment";
    protected $saveQuery = "sp_emailsattachments_save";
    protected $saveArgs = array("idemail", "idfile", "dtregister");
    protected $pk = array(idemail, idfile);

    public function get(){}

}

?>