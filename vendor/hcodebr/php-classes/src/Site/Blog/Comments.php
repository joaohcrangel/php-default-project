<?php

namespace Hcode\Site\Blog;

use \Hcode\Collection;

class Comments extends Collection {

    protected $class = "Hcode\Site\Blog\Comment";
    protected $saveQuery = "sp_blogcomments_save";
    protected $saveArgs = array("idcomment", "idcommentfather", "idpost", "idperson", "descomment", "inapproved", "nrsubcomments");
    protected $pk = "idcomment";

    public function get(){}

    public function getByHcode_Site_Blog_Post(Post $post):Comments
    {

    	$this->loadFromQuery("CALL sp_commentsfrompost_list(?);", array(
    		$post->getidpost()
    	));

    	return $this;
    	
    }

}

?>