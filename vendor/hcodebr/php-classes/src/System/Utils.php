<?php 

namespace Hcode\System;

use \DateTime;

class Utils {

	public static function getDateTimeDiffHuman(DateTime $dt1, DateTime $dt2, $precision = 2 ):string
	{

		$interval = $dt1->diff($dt2);

		$strings = array(
			array(
				'format'=>'%Y',
				'singular'=>'ano',
				'plural'=>'anos'
			),
			array(
				'format'=>'%m',
				'singular'=>'mês',
				'plural'=>'meses'
			),
			array(
				'format'=>'%a',
				'singular'=>'dia',
				'plural'=>'dias'
			),
			array(
				'format'=>'%h',
				'singular'=>'hora',
				'plural'=>'horas'
			),
			array(
				'format'=>'%i',
				'singular'=>'minuto',
				'plural'=>'minutos'
			),
			array(
				'format'=>'%s',
				'singular'=>'segundo',
				'plural'=>'segundos'
			)
		);

		$final = array();

		foreach ($strings as $string) {
			$n = (int)$interval->format($string['format']);
			if ($n > 0) {
				array_push($final, $n.' '.(($n === 1)?$string['singular']:$string['plural']));
			}
		}

		$return = array();

		for ($i=0; $i < $precision; $i++) { 
			if (count($final) === 0) break;
			array_push($return, array_shift($final));
		}

		return implode(' ', $return);

	}

}

 ?>