<?php
class AdminPage {
  	
	private $language;
	private $Tpl;
  	
	public $options = array(
		"data"=>array(
			"js"=>array(),
			"head_title"=>"Adminsitração - VnoMapa",
			"meta_description"=>"",
			"meta_author"=>"HCODE"
		)
	);
 
	public function __construct($options = array()){
		/*
		RainTPL::configure("base_url", PATH );
		RainTPL::configure("tpl_dir", PATH."/res/tpl/admin/" );
		RainTPL::configure("cache_dir", PATH."/res/tpl/tmp/admin/" );
		RainTPL::configure("path_replace", false );
		*/
		$options = array_merge($this->options, $options);

		$this->language = new Language();

		$options['data']['string'] = $this->language->loadString();
		if(isset($_SESSION)) $options['data']['session'] = $_SESSION;
		if(isset($_SERVER)) $options['data']['server'] = $_SERVER;
		$options['data']['path'] = SITE_PATH;

		$tpl = $this->getTpl();
		$this->options = $options;

		$tpl->configure(array(
			'base_url'=>PATH,
			'tpl_dir'=>PATH."/res/tpl/admin/",
			'cache_dir'=>PATH."/res/tpl/tmp/admin/",
			'path_replace'=>false
		));
 
		if(gettype($this->options['data'])=='array'){
			foreach($this->options['data'] as $key=>$val){
				$tpl->assign($key, $val);
			}
		}
 
		$tpl->draw("header", false);

		exit('OK');
 
	}

	public function getString($name){

		return $this->language->getString($name);

	}
 
	public function __destruct(){
 
		$tpl = $this->getTpl();
 
		if(gettype($this->options['data'])=='array'){
			foreach($this->options['data'] as $key=>$val){
				$tpl->assign($key, $val);
			}
		}
 
		$tpl->draw("footer", false);
 
	}
 
	public function setTpl($tplname, $data = array(), $returnHTML = false){
 
		$tpl = $this->getTpl();
 
		if(gettype($data)=='array'){
			foreach($data as $key=>$val){
				$tpl->assign($key, $val);
			}
		}
 
		return $tpl->draw($tplname, $returnHTML);
 
	}
  
	public function getTpl(){
 
		return ($this->Tpl)?$this->Tpl:$this->Tpl = new RainTPL;
 
	}
 
}
?>
