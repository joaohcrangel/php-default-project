<?php

namespace Hcode;

use Hcode\Locale\Language;
use Rain\Tpl;

abstract class Page {

	private $language;
	private $Tpl;

	public $options = array(
		"header"=>true,
		"footer"=>true,
		"data"=>array(
			"body"=>array(
				"class"=>""
			),
			"js"=>array(),
			"head_title"=>"Título do Site",
			"meta_description"=>"Descrição",
			"meta_author"=>"João Rangel"
		)
	);

	public function getString($name):string
	{

		return $this->language->getString($name);

	}

	public function __destruct()
	{

		$tpl = $this->getTpl();

		if(gettype($this->options['data'])=='array'){
			foreach($this->options['data'] as $key=>$val){
				$tpl->assign($key, $val);
			}
		}

		if ($this->options['footer'] === true) $tpl->draw("footer", false);

	}

	public function setTpl($tplname, $data = array(), $returnHTML = false)
	{

		$tpl = $this->getTpl();

		if(gettype($data)=='array'){
			foreach($data as $key=>$val){
				$tpl->assign($key, $val);
			}
		}

		return $tpl->draw($tplname, $returnHTML);

	}

	public function getTpl():Tpl
	{

		return ($this->Tpl)?$this->Tpl:$this->Tpl = new Tpl;

	}

}
?>
