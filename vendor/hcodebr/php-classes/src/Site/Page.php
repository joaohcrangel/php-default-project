<?php

namespace Hcode\Site;

use Hcode\Page;
use Hcode\Locale\Language;
use Rain\Tpl;

class Page extends Page {

	private function getConfig():array
	{

		return array(
			"base_url"      => PATH,
			"tpl_dir"       => PATH."/res/tpl/",
			"cache_dir"     => PATH."/res/tpl/tmp/",
			"debug"         => false
	    );

	}

}
?>