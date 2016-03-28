<?php 
class Language {
	
	private $default = "en";
	private $strings;

	public function __construct($lang = NULL){

		if(isset($_GET['lang'])) $_SESSION["lang"] = get('lang');

		if($lang === NULL && isset($_SESSION['lang'])){

			$lang = $_SESSION['lang'];

		}else{

			$lang = $_SESSION['lang'] = $this->default;

		}

		if($this->strings && gettype($this->strings)==='array') return $this->strings;

		$file_string = PATH."/res/strings/$lang.xml";

		$strings = array();

		if(file_exists($file_string)){

			$xml = simplexml_load_file($file_string);

			foreach($xml->children() as $string){
                $val = (string)$string->attributes();
                $strings[$val[0]] = (string)$string;                
			}

		}

		return $this->strings = $strings;

	}

	public function loadString(){

		return $this->strings;

	}

	public function getString($name){

		$strings = $this->loadString($_SESSION['lang']);
		return $strings[$name];

	}

}
?>
