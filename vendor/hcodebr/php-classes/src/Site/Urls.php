<?php

namespace Hcode\Site;

use Hcode\Collection;

class Urls extends Collection {

    protected $class = "Hcode\Site\Url";
    protected $saveQuery = "sp_urls_save";
    protected $saveArgs = array("idurl", "desurl", "destitle");
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