<?php 

class Sql extends PDO {

	private $conn;
	private $utf8 = true;

	public function __construct()
	{

		$this->conn = new PDO('mysql:host='.$this->server.';dbname='.$this->database, $this->username, $this->password);

    	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

		return $this->conn;

	}

	public function __destruct()
	{



	}

	public function query($query, $params = array(), $multi = false)
	{

		$stmt = $this->conn->prepare($query);

		$stmt->execute($params);

		return $stmt;

	}

	public function arrays():array
	{

		$args = func_get_args();

		switch (count($args)) {
			case 1:
			$query = $args[0];
			$array = false;
			$params = array();
			break;

			case 2:
			$query = $args[0];
			$array = false;
			$params = $args[1];
			break;

			case 3:
			$query = $args[0];
			$array = $args[1];
			$params = $args[2];
			break;
		}

		$stmt = $this->query($query, $params, false);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

	public function select($query, $params = array())
	{

		$results = $this->arrays($query, $params);

		return (count($results) > 0)?$results[0]:array();

	}

	public function querys($querys = array(), $params = array())
	{




	}

	public function insert($query, $params = array())
	{

		return $this->select($query, $params);

	}

	private function getParamsSymbols($params, $symbol = "?"):array
	{

		$i = array();
		foreach ($params as $p) {
			array_push($i, $symbol);
		}

		return $i;

	}

	public function proc($name, $params = array(), $returnQuery = false){

		$query = "CALL $name(".implode(",", $this->getParamsSymbols()).")";

		return $this->arrays($query, $params);

	}

	public function queryFromFile($filename, $params = array())
	{

		if (file_exists($filename)) {

			return $this->query(file_get_contents($filename), $params);

		} else {

			throw new SqlException("O arquivo {$filename} não existe.", 400);
		
		}

	}

	public function getDataBases():array
	{

		$rows = array();
		foreach ($this->arrays("SHOW DATABASES") as $row) {
			array_push($rows, $row["Database"]);
		}
		return $rows;

	}

	public function getTables($database):array
	{

		$rows = array();
		foreach($this->arrays("SHOW TABLES FROM $database") as $row){
			array_push($rows, $row["Tables_in_$database"]);
		}
		return $rows;

	}

}

?>