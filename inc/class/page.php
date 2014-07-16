<?php
class Page {
  
	public $options = array(
		"data"=>array(
			"js"=>array(),
			"head_title"=>"PHP Default Project",
			"meta_description"=>"",
			"meta_author"=>""
		)
	);
 
	public function __construct($options = array()){

		$rootdir = PATH;//realpath(__DIR__."/../../");

		raintpl::configure("base_url", $rootdir );
		raintpl::configure("tpl_dir", $rootdir."/res/tpl/" );
		raintpl::configure("cache_dir", $rootdir."/res/tpl/tmp/" );
		raintpl::configure("path_replace", false );

		$options = array_merge($this->options, $options);
 
		$tpl = $this->getTpl();
		$this->options = $options;
 
		if(gettype($this->options['data'])=='array'){
			foreach($this->options['data'] as $key=>$val){
				$tpl->assign($key, $val);
			}
		}
 
		$tpl->draw("header", false);
 
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