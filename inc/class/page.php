<?php
class Page {
  	
	private $strings;
  	
	public $options = array(
		"strings"=>"pt-br",//Idioma padrão res/strings/pt-br.xml
		"data"=>array(
			"js"=>array(),
			"head_title"=>"Título da Página",
			"meta_description"=>"",
			"meta_author"=>"João Rangel"
		)
	);
 
	public function __construct($options = array()){

		$rootdir = PATH;

		raintpl::configure("base_url", $rootdir );
		raintpl::configure("tpl_dir", $rootdir."/res/tpl/" );
		raintpl::configure("cache_dir", $rootdir."/res/tpl/tmp/" );
		raintpl::configure("path_replace", false );

		$options = array_merge($this->options, $options);

		if(isset($_SESSION["lang"])) $options["strings"] = $_SESSION["lang"];
 	
		$options['data']['string'] = $this->loadString($options["strings"]);

		$tpl = $this->getTpl();
		$this->options = $options;	
 
		if(gettype($this->options['data'])=='array'){
			foreach($this->options['data'] as $key=>$val){
				$tpl->assign($key, $val);
			}
		}
 
		$tpl->draw("header", false);
 
	}

	public function getString($name){

		$strings = $this->loadString($options["strings"]);
		return $strings[$name];

	}

	public function loadString($lang){

		if($this->strings && gettype($this->strings)==='array') return $this->strings;

		$file_string = PATH."/res/strings/$lang.xml";

		$strings = array();

		if(file_exists($file_string)){

			$xml = simplexml_load_file($file_string);

			foreach($xml->children() as $string){
                $val = $string->attributes();
                //$strings[(string)$val[0]] = (string)$string;
                $strings[(string)$string->attributes()[0]] = (string)$string;
			}

		}

		return $this->strings = $strings;

	}
	
	public function getString($name){

		$strings = $this->loadString($options["strings"]);
		return $strings[$name];

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
