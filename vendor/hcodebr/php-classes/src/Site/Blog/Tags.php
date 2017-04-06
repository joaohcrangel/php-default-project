<?php

namespace Hcode\Site\Blog;

use \Hcode\Collection;

class Tags extends Collection {

    protected $class = "Hcode\Site\Blog\Tag";
    protected $saveQuery = "sp_blogtags_save";
    protected $saveArgs = array("idtag", "destag");
    protected $pk = "idtag";

    public function get(){}

    public static function listAll():Tags
    {

    	$tags = new Tags();

    	$tags->loadFromQuery("CALL sp_blogtags_list();");

    	return $tags;

    }

    public function getByBlogPost(Post $post):Tags
    {

        $this->loadFromQuery("CALL sp_tagsfrompost_list(?);", array(
            $post->getidpost()
        ));

        return $this;

    }

}

?>