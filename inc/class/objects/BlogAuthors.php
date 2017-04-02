<?php

class BlogAuthors extends Collection {

    protected $class = "BlogAuthor";
    protected $saveQuery = "sp_blogauthors_save";
    protected $saveArgs = array("idauthor", "iduser", "desauthor", "desresume", "idphoto");
    protected $pk = "idauthor";

    public function get(){}

}

?>