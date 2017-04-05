<?php

namespace Hcode;

class BlogTags extends Collection {

    protected $class = "Hcode\BlogTag";
    protected $saveQuery = "sp_blogtags_save";
    protected $saveArgs = array("idtag", "destag");
    protected $pk = "idtag";

    public function get(){}

    public static function listAll():BlogTags
    {

    	$tags = new BlogTags();

    	$tags->loadFromQuery("CALL sp_blogtags_list();");

    	return $tags;

    }

    public function getByBlogPost(BlogPost $post):BlogTags
    {

        $this->loadFromQuery("CALL sp_tagsfrompost_list(?);", array(
            $post->getidpost()
        ));

        return $this;

    }

}

?>