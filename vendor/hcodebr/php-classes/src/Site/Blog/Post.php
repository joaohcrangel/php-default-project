<?php

namespace Hcode\Site\Blog;

use \Hcode\Model;

class Post extends Model {

    public $required = array('destitle', 'idurl', 'descontentshort', 'descontent', 'idauthor');
    protected $pk = "idpost";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_blogposts_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_blogposts_save(?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidpost(),
                $this->getdestitle(),
                $this->getidurl(),
                $this->getdescontentshort(),
                $this->getdescontent(),
                $this->getidauthor(),
                $this->getdtpublished(),
                $this->getintrash(),
                $this->getidcover()
            ));

            return $this->getidpost();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_blogposts_remove", array(
            $this->getidpost()
        ));

        return true;
        
    }

    public function getTags():Tags
    {
        return new Tags($this);
    }

    public function getCategories():Categories
    {
        return new Categories($this);
    }

    public function getComments():Comments
    {
        return new Comments($this);
    }

    public function removeTags():bool
    {

        $this->execute("CALL sp_blogpoststags_remove(?);", array(
            $this->getidpost()
        ));

        return true;

    }

    public function addTag(Tag $tag):Tag
    {

        $this->execute("CALL sp_blogpoststags_save(?, ?);", array(
            $this->getidpost(),
            $tag->getidtag()
        ));

        return $tag;

    }

    public function removeCategories():bool
    {

        $this->execute("CALL sp_blogpostscategories_remove(?);", array(
            $this->getidpost()
        ));

        return true;

    }

    public function addCategory(Category $category):Category
    {

        $this->execute("CALL sp_blogpostscategories_save(?, ?);", array(
            $this->getidpost(),
            $category->getidcategory()
        ));

        return $category;

    }

    public static function getByUrl($desurl):Post
    {

        $post = new Post();

        $post->queryToAttr("CALL sp_blogpostbyurl_get(?);", array(
            $desurl
        ));

        return $post;

    }

}

?>