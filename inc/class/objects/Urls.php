<?php

class Urls extends Collection {

    protected $class = "Url";
    protected $saveQuery = "sp_urls_save";
    protected $saveArgs = array("idurl", "desurl", "destitulo");
    protected $pk = "idurl";

    public function get(){}

    public static function listAll():Urls
    {

    	$urls = new Urls();

    	$urls->loadFromQuery("CALL sp_urls_list();");

    	return $urls;

    }

}

?>