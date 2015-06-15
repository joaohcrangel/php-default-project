<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
namespace ChatV3;

class Paged {

	private $limit = 50;
	private $start = 0;
	private $end = NULL;
	private $sort = '';
	private $dir = '';
	private $totalRows = 0;
	private $data = array();
	private $query = NULL;
	private $queryParams = array();
	private $fieldNameTotal = 'TotalRows';
	private $executed = false;

	public function __construct($query, $start = 0, $limit = 50, $sort = '', $dir = ''){

		$this->setQuery($query);
		$this->setStart($start);
		$this->setLimit($limit);
		$this->setSort($sort);
		$this->setDir($dir);

		$this->execute();

	}

	public function setQuery($query){
		$this->query = $query;
	}

	public function setQueryParams($queryParams){
		$this->queryParams = $queryParams;
	}

	public function setStart($start){
		$this->start = $start;
		$this->end = $this->start + $this->limit;
		$this->start++;
	}

	public function setLimit($limit){
		$this->limit = $limit;
		$this->end = $this->start + $this->limit;
	}

	public function setSort($sort){
		$this->sort = $sort;
	}

	public function setDir($dir){
		$this->dir = $dir;
	}

	private function execute(){

		$sql = new Sql();

		$queryParams = (gettype($this->queryParams)==='array')?$this->queryParams:array();

		switch($sql->getType()){

			case Sql::SQLSERVER:
			array_push($queryParams, $this->start, $this->end);
			break;

			case Sql::MYSQL:
			array_push($queryParams, $this->start, $this->limit);
			break;

		}

		$result = $sql->arrays($this->query, false, $queryParams);

		$this->data = $result;
		$this->totalRows = (count($result) > 0)?$result[0][$this->fieldNameTotal]:0;

		$this->executed = true;
		
	}
 	
	public function getData(){
		if (!$this->executed) $this->execute();
		return $this->data;
	}

	public function getTotal(){
		if (!$this->executed) $this->execute();
		return $this->totalRows;
	}

	public function getStart(){
		return $this->start;
	}

	public function getEnd(){
		return $this->end;
	}

	public function getLimit(){
		return $this->limit;
	}

}
?>
