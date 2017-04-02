<?php

class BlogPosts extends Collection {

    protected $class = "BlogPost";
    protected $saveQuery = "sp_blogposts_save";
    protected $saveArgs = array("idpost", "destitle", "idurl", "descontentshort", "descontent", "idauthor");
    protected $pk = "idpost";

    public function get(){}

}

?>