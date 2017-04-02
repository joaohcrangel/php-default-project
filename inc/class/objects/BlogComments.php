<?php

class BlogComments extends Collection {

    protected $class = "BlogComment";
    protected $saveQuery = "sp_blogcomments_save";
    protected $saveArgs = array("idcomment", "idcommentfather", "idpost", "idperson", "descomment");
    protected $pk = "idcomment";

    public function get(){}

}

?>