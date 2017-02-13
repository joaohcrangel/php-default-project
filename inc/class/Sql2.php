<?php 

<<<<<<< HEAD
class Sql extends PDO {

	private $conn;
	private $utf8 = true;
=======
class Sql {

	private $conn;

	private $type = DB_TYPE;

	private $server = DB_HOST;
	private $username = DB_USER;
	private $password = DB_PASSWORD;
	private $database = DB_NAME;
>>>>>>> efc0d07f6939fda78f0d791e9fdcfbdf77684b36

	public function __construct()
	{

		$this->conn = new PDO('mysql:host='.$this->server.';dbname='.$this->database, $this->username, $this->password);

    	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

<<<<<<< HEAD
	}

	public function query($rawQuery, $params = array()):array
	{

		$sth = $this->conn->prepare($rawQuery);

		$sth->execute($params);

		return $this->getArrayRows($sth);

	}

	public function getArrayRows($statement):array
	{

		$data = $statement->fetchAll();

		foreach ($data as &$row) {
			
			foreach ($row as $key => $value) {
				if (is_numeric($key)) unset($row[$key]);
			}

			foreach ($fields as $f) {
			
				switch ($f['type']) {

					case 'NEWDECIMAL':
					$row[$f['field']] = (float)$row[$f['field']];
					$row['des'.$f['field']] = number_format((float)$row[$f['field']], 2, ',', '.');
					break;

					case 'LONG':
					case 'INTEGER':
					$row[$f['field']] = (int)$row[$f['field']];
					break;

					case 'BIT':
					$row[$f['field']] = (bool)$row[$f['field']];
					break;

					case 'TIMESTAMP':
					$row[$f['field']] = $row[$f['field']];
					$row['des'.$f['field']] = date("d/m/Y", strtotime($row[$f['field']]));
					$row['ts'.$f['field']] = strtotime($row[$f['field']]);
					break;

					case 'VAR_STRING':
					case 'STRING':
					$row[$f['field']] = ($this->utf8 === true)?trim(utf8_encode(trim($row[$f['field']]))):trim($row[$f['field']]);
					break;

				}

			}

		}

		return $data;
=======
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
>>>>>>> efc0d07f6939fda78f0d791e9fdcfbdf77684b36

	}

}

<<<<<<< HEAD
?>
=======
 ?>
>>>>>>> efc0d07f6939fda78f0d791e9fdcfbdf77684b36
