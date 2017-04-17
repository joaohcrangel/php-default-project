<?php 

namespace Hcode\Sql;

use Hcode\Model;

class Column extends Model {
	
	public function get(){}
	public function save(){}
	public function remove(){}

	public function getinpk(){

		return ($this->getCOLUMN_KEY() === 'PRI');

	}

	public function getinnull(){

		return !($this->getIS_NULLABLE() === 'NO');

	}

}

?>