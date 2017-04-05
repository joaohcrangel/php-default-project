<?php

namespace Hcode;

class BlogPosts extends Collection {

    protected $class = "Hcode\BlogPost";
    protected $saveQuery = "sp_blogposts_save";
    protected $saveArgs = array("idpost", "destitle", "idurl", "descontentshort", "descontent", "idauthor", "dtpublished", "intrash", "idcover");
    protected $pk = "idpost";

    public function get(){}

}

?>