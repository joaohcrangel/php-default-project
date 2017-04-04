<?php

class BlogCategories extends Collection {

    protected $class = "BlogCategory";
    protected $saveQuery = "sp_blogcategories_save";
    protected $saveArgs = array("idcategory", "descategory");
    protected $pk = "idcategory";

    public function get(){}

    public static function listAll():BlogCategories
    {

    	$categories = new BlogCategories();

    	$categories->loadFromQuery("CALL sp_blogcategories_list();");

    	return $categories;

    }

    public function getByPost(BlogPost $post):BlogCategories
    {

        $this->loadFromQuery("CALL sp_categoriesfrompost_list(?);", array(
            $post->getidpost()
        ));

        return $this;

    }

}

?>