<?php

namespace Hcode\Site\Blog;

use \Hcode\Collection;

class Authors extends Collection {

    protected $class = "Hcode\Site\Blog\Author";
    protected $saveQuery = "sp_blogauthors_save";
    protected $saveArgs = array("idauthor", "iduser", "desauthor", "desresume", "idphoto");
    protected $pk = "idauthor";

    public function get(){}

}

?>