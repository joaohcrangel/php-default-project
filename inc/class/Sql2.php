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

		$sth = $this->conn->prepare($query);

		$sth->execute($params);

		$resource = $this->conn->exec($query);

		return $resource;

	}

	public function arrays($query, $array = false, $params = array()):array
	{

		$resource = $this->query($query, $params, false);

	}

	public function select($query, $params = array())
	{

		return $this->arrays($query, true, $params);

	}

	public function querys($querys = array(), $params = array())
	{




	}

	public function insert($query, $params = array())
	{

		return $this->select($query, $params);

	}

	public function proc($name, $params = array(), $returnQuery = false){



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