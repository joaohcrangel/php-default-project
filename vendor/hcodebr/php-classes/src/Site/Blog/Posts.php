<?php

namespace Hcode\Site\Blog;

use \Hcode\Collection;

class Posts extends Collection {

    protected $class = "Hcode\Site\Blog\Post";
    protected $saveQuery = "sp_blogposts_save";
    protected $saveArgs = array("idpost", "destitle", "idurl", "descontentshort", "descontent", "idauthor", "dtpublished", "intrash", "idcover");
    protected $pk = "idpost";

    public function get(){}

}

?>