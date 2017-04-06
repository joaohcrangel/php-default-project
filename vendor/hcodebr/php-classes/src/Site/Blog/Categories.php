<?php

namespace Hcode\Site\Blog;

use \Hcode\Collection;

class Categories extends Collection {

    protected $class = "Hcode\Site\Blog\Category";
    protected $saveQuery = "sp_blogcategories_save";
    protected $saveArgs = array("idcategory", "descategory");
    protected $pk = "idcategory";

    public function get(){}

    public static function listAll():Categories
    {

    	$categories = new Categories();

    	$categories->loadFromQuery("CALL sp_blogcategories_list();");

    	return $categories;

    }

    public function getByBlogPost(Post $post):Categories
    {

        $this->loadFromQuery("CALL sp_categoriesfrompost_list(?);", array(
            $post->getidpost()
        ));

        return $this;

    }

}

?>