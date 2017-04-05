<?php

namespace Hcode\Locale;

class Language {

	private $default = "pt-BR";
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
                $val = $string->attributes();
                //$strings[(string)$val[0]] = (string)$string;
                $strings[(string)$string->attributes()[0]] = (string)$string;
			}

		}

		return $this->strings = $strings;

	}

	public function loadString(){

		return $this->strings;

	}

	public function getString($name){

		$strings = $this->loadString($_SESSION['lang']);

		return (isset($strings[$name]))?$strings[$name]:'';

	}

	public static function getWeekdays(){

		$lang = new Language();

		return array(
			array(
				'nrweekday'=>0,
				'desweekday'=>$lang->getString('weekdayname_0'),
			),
			array(
				'nrweekday'=>1,
				'desweekday'=>$lang->getString('weekdayname_1'),
			),
			array(
				'nrweekday'=>2,
				'desweekday'=>$lang->getString('weekdayname_2'),
			),
			array(
				'nrweekday'=>3,
				'desweekday'=>$lang->getString('weekdayname_3'),
			),
			array(
				'nrweekday'=>4,
				'desweekday'=>$lang->getString('weekdayname_4'),
			),
			array(
				'nrweekday'=>5,
				'desweekday'=>$lang->getString('weekdayname_5'),
			),
			array(
				'nrweekday'=>6,
				'desweekday'=>$lang->getString('weekdayname_6'),
			)
		);

	}

	public static function getMonthName($nrmonth){

		$months = Language::getMonths();

		if (isset($months[$nrmonth-1])) {
			return $months[$nrmonth-1]['desmonth'];
		} else {
			return '';
		}

	}

	public static function getMonths(){

		$lang = new Language();

		return array(
			array(
				'nrmonth'=>1,
				'desmonth'=>$lang->getString('monthname_1'),
			),
			array(
				'nrmonth'=>2,
				'desmonth'=>$lang->getString('monthname_2'),
			),
			array(
				'nrmonth'=>3,
				'desmonth'=>$lang->getString('monthname_3'),
			),
			array(
				'nrmonth'=>4,
				'desmonth'=>$lang->getString('monthname_4'),
			),
			array(
				'nrmonth'=>5,
				'desmonth'=>$lang->getString('monthname_5'),
			),
			array(
				'nrmonth'=>6,
				'desmonth'=>$lang->getString('monthname_6'),
			),
			array(
				'nrmonth'=>7,
				'desmonth'=>$lang->getString('monthname_7'),
			),
			array(
				'nrmonth'=>8,
				'desmonth'=>$lang->getString('monthname_8'),
			),
			array(
				'nrmonth'=>9,
				'desmonth'=>$lang->getString('monthname_9'),
			),
			array(
				'nrmonth'=>10,
				'desmonth'=>$lang->getString('monthname_10'),
			),
			array(
				'nrmonth'=>11,
				'desmonth'=>$lang->getString('monthname_11'),
			),
			array(
				'nrmonth'=>12,
				'desmonth'=>$lang->getString('monthname_12'),
			)
		);

	}

}
?>
