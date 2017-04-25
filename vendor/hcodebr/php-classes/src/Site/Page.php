<?php

namespace Hcode\Site;

use Hcode\Locale\Language;
use Rain\Tpl;
use Hcode\Session;

class Page extends \Hcode\Page {

	public function getConfig():array
	{

		return array(
			"base_url"      => PATH,
			"tpl_dir"       => PATH."/res/tpl/",
			"cache_dir"     => PATH."/res/tpl/tmp/",
			"debug"         => false,
			"auto_escape"	=> false
	    );

	}

	public function __construct($options = array())
	{

		Tpl::configure( $this->getConfig());

		$options = array_merge($this->options, $options);

		$this->language = new Language();

		$options['data']['string'] = $this->language->loadString();

		$user = Session::getUser();

		$options['data']['user'] = $user->getFields();
		if (isset($_SESSION)) $options['data']['session'] = $_SESSION;
		if (isset($_SERVER)) $options['data']['server'] = $_SERVER;
		$options['data']['path'] = SITE_PATH;

		$tpl = $this->getTpl();
		$this->options = $options;

		if (gettype($this->options['data'])=='array') {
			foreach($this->options['data'] as $key=>$val){
				$tpl->assign($key, $val);
			}
		}

		if ($options['header'] === true) $tpl->draw("header", false);

	}

}
?>