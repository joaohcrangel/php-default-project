<?php

namespace Hcode;

class BlogComments extends Collection {

    protected $class = "Hcode\BlogComment";
    protected $saveQuery = "sp_blogcomments_save";
    protected $saveArgs = array("idcomment", "idcommentfather", "idpost", "idperson", "descomment", "inapproved");
    protected $pk = "idcomment";

    public function get(){}

}

?>