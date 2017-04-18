<?php

namespace Hcode\Email;

use Hcode\Collection;

class Attachments extends Collection {

    protected $class = "Hcode\Email\Attachment";
    protected $saveQuery = "sp_emailsattachments_save";
    protected $saveArgs = array("idemail", "idfile", "dtregister");
    protected $pk = array(idemail, idfile);

    public function get(){}

}

?>