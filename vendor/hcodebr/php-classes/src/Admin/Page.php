<?php

namespace Hcode\Admin;

use Hcode\Locale\Language;
use Hcode\Session;
use Hcode\System\Configurations;
use Rain\Tpl;

class Page extends \Hcode\Page {
  	
	public function getConfig(){

		return array(
			"base_url"      => PATH,
			"tpl_dir"       => PATH."/res/tpl/admin/",
			"cache_dir"     => PATH."/res/tpl/tmp/admin/",
			"debug"         => false,
			"auto_escape"	=> false
	    );

	}
 
	public function __construct($options = array())
	{

		Tpl::configure( $this->getConfig() );

		$options = array_merge_recursive_distinct($this->options, $options);
		$options['data']['head_title'] .= " - Adminsitração";

		$this->language = new Language();

		$options['data']['string'] = $this->language->loadString();

		$conf = Session::getConfigurations();

		if ($conf->getSize() === 0) {
			$configurations = Configurations::listAll();
			Session::setConfigurations($configurations);
		}

		$options['data']['conf'] = Session::getConfigurations()->getNames();

		if(isset($_SESSION)) $options['data']['session'] = $_SESSION;
		if(isset($_SERVER)) $options['data']['server'] = $_SERVER;
		$options['data']['path'] = SITE_PATH;
		$options['data']['pathAdmin'] = SITE_PATH."/".DIR_ADMIN;

		$tpl = $this->getTpl();
		$this->options = $options;
 
		if(gettype($this->options['data'])=='array'){
			foreach($this->options['data'] as $key=>$val){
				$tpl->assign($key, $val);
			}
		}
 
		if ($this->options['header'] === true) $tpl->draw("header", false);
 
	}
 
}
?>
