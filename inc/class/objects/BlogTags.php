<?php

class BlogTags extends Collection {

    protected $class = "BlogTag";
    protected $saveQuery = "sp_blogtags_save";
    protected $saveArgs = array("idtag", "destag");
    protected $pk = "idtag";

    public function get(){}

}

?>