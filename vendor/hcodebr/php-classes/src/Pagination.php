<?php 
/**
*
*   ***********************************************
*	ATENÇÂO
*   ***********************************************
*	A query de conter o seguinte comando: SQL_CALC_FOUND_ROWS
*
*	SELECT SQL_CALC_FOUND_ROWS * FROM...
*
*   ***********************************************
*   EXEMPLO:
*   ***********************************************
*	$pagination = new Pagination(
*	    'CALL sp_pessoassearch_list(?)',//Query
*	    array(
*	        $dessearch
*	    ),//Params,
*	    'Pessoas',//Result Collection
*	    10,//Items per Page
*	);
*
*	$pessoas = $pagination->getPage(1);
*	$nrpaginas = $pagination->getTotalPages();
*	$nritems = $pagination->getTotal();
*   ***********************************************
*
*/
namespace Hcode;

class Pagination {

	const COLUMN_TOTAL_NAME = "nrtotal";

	private $query;
	private $originalParams;
	private $params;
	private $collectionName;
	private $itemsPerPage;

	private $totalItems = 0;
	private $totalPages = 0;

	public function __construct(
		$query,
		$params = array(),
		$collectionName = 'Hcode\Collection',
		$itemsPerPage = 100
	){

		$this->query = $query;
		$this->originalParams = $this->params = $params;
		$this->collectionName = $collectionName;
		$this->itemsPerPage = ($itemsPerPage > 0)?$itemsPerPage:100;

	}

	public function getPage($nrpage = 1){

		if ($nrpage < 1) $nrpage = 1;

		$this->params = $this->originalParams;

		array_push($this->params, (($nrpage-1) * $this->itemsPerPage), $this->itemsPerPage);	

		$collection = new $this->collectionName;

		$sql = new Sql();

		$result1 = $sql->arrays($this->query, false, $this->params);		
		$result2 = $sql->select('SELECT FOUND_ROWS() AS '.Pagination::COLUMN_TOTAL_NAME.';');

		$collection->load($result1);

		$this->totalItems = $result2[Pagination::COLUMN_TOTAL_NAME];
		$this->totalPages = ($this->totalItems / $this->itemsPerPage);

		return $collection;

	}

	public function getTotalPages(){

		return (int)ceil($this->totalPages);

	}

	public function getTotal(){

		return (int)$this->totalItems;

	}

	public function getItemsPerPage(){

		return (int)$this->itemsPerPage;

	}

}

?>