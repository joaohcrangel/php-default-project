<?php
class Page {
  
	public $options = array(
		"data"=>array(
			"js"=>array(),
			"title"=>"",
			"meta_description"=>"",
			"meta_author"=>""
		)
	);
 
	public function __construct($options = array()){
 
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