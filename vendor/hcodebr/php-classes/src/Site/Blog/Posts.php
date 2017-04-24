<?php

namespace Hcode\Site\Blog;

use \Hcode\Collection;

class Posts extends Collection {

    protected $class = "Hcode\Site\Blog\Post";
    protected $saveQuery = "sp_blogposts_save";
    protected $saveArgs = array("idpost", "destitle", "idurl", "descontentshort", "descontent", "idauthor", "dtpublished", "intrash", "idcover");
    protected $pk = "idpost";

    public function get(){}

    public function getByHcode_Site_Blog_Author(Author $author):Posts
    {

    	$this->loadFromQuery("CALL sp_postsfromauthor_list(?);", array(
    		$author->getidauthor()
    	));

    	return $this;

    }

}

?>