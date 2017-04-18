<?php

class BlogComments extends Collection {

    protected $class = "BlogComment";
    protected $saveQuery = "sp_blogcomments_save";
    protected $saveArgs = array("idcomment", "idcommentfather", "idpost", "idperson", "descomment", "inapproved");
    protected $pk = "idcomment";

    public function get(){}

    public function getByBlogPost(BlogPost $post):BlogComments
    {

    	$this->loadFromQuery("CALL sp_commentsfrompost_list(?);", array(
    		$post->getidpost()
    	));

    	return $this;

    }

}

?>