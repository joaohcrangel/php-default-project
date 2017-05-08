<?php 

namespace Hcode;

use \PDO;
use \DateTime;
use Hcode\Sql\Exception;

class Sql extends PDO {

	private $conn;
	private $statements = array();
	private $utf8 = true;

	private $type = DB_TYPE;

	private $server = DB_HOST;
	private $username = DB_USER;
	private $password = DB_PASSWORD;
	private $database = DB_NAME;

	public function __construct()
	{

		$this->conn = new PDO('mysql:host='.$this->server.';dbname='.$this->database, $this->username, $this->password);

    	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		return $this->conn;

	}

	public function __destruct()
	{



	}

	public function exec($query)
	{

		return $this->conn->exec($query);

	}

	public function query($query, $params = array(), $multi = false)
	{

		$stmt = $this->conn->prepare($query);
		$stmt->execute($this->validParams($params));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->nextRowset();

		foreach($results as $key => $value){
 
 			foreach ($value as $index => $row) {
 
 				switch(gettype($row)){

 					case "string": 					
 					$results[$key][$index] = utf8_encode($row);
 					break;
 
 				}
 
 			}
 
 		}
		
		return $results;

	}

	private function validParams($params):array
	{

		$params_new = array();

		foreach ($params as $value) {

			switch(strtolower(gettype($value))){
				case 'string':
				$value = ($this->utf8 === true)?utf8_decode($value):$value;
				array_push($params_new, $value);
				break;
				case 'integer':
				case 'float':
				case 'double':
				array_push($params_new, $value);
				break;
				case 'bool':
				case 'boolean':
				array_push($params_new, (bool)$value);
				break;
				case 'null':
				array_push($params_new, NULL);
				break;
				default:
				array_push($params_new, "");
				break;
			}

		}

		return $params_new;

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

		$stmt = $this->conn->prepare($query);
		$stmt->execute($this->validParams($params));
		$results = $this->getResults($stmt);
		$stmt->nextRowset();

		return $results;

	}

	private function getFields($stmt){

		$fields = array();

		for ($i=0; $i < $stmt->columnCount(); $i++) {
			$metadata = $stmt->getColumnMeta($i);
			array_push($fields, array(
				"field"=>$metadata['name'],
				"type"=>strtoupper($metadata['native_type']),
				"max_length"=>$metadata['len']
			));
		}

		return $fields;

	}

	private function getResults($stmt):array
	{

		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$fields = $this->getFields($stmt);

		foreach ($data as &$row) {

			if (count($row) > 0) {

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

						case 'DATE':
						if ($row[$f['field']]) {
							$row[$f['field']] = $row[$f['field']];
							$row['des'.$f['field']] = date("d/m/Y", strtotime($row[$f['field']]));
							$row['ts'.$f['field']] = strtotime($row[$f['field']]);
							$row['obj'.$f['field']] = new DateTime($row[$f['field']]);
						} else {
							$row['des'.$f['field']] = '';
							$row['ts'.$f['field']] = '';
							$row['obj'.$f['field']] = NULL;
						}
						break;

						case 'TIMESTAMP':
						case 'DATETIME':
						$row[$f['field']] = $row[$f['field']];
						if ($row[$f['field']]) {
							$row['des'.$f['field']] = date("d/m/Y H:i:s", strtotime($row[$f['field']]));
							$row['ts'.$f['field']] = strtotime($row[$f['field']]);
							$row['obj'.$f['field']] = new DateTime($row[$f['field']]);
						} else {
							$row['des'.$f['field']] = '';
							$row['ts'.$f['field']] = '';
							$row['obj'.$f['field']] = NULL;
						}
						break;

						case 'VAR_STRING':
						case 'STRING':
						$row[$f['field']] = ($this->utf8 === true)?trim(utf8_encode(trim($row[$f['field']]))):trim($row[$f['field']]);
						break;

					}

				}

			}

		}

		return $data;

	}

	public function select($query, $params = array())
	{

		$results = $this->arrays($query, $params);

		return (count($results) > 0)?$results[0]:array();

	}

	public function querys($querys = array(), $params = array())
	{

		$stmt = $this->query(implode(";",$querys), $params, true);

		return $this->getResults($stmt);

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

		$query = "CALL $name(".implode(",", $this->getParamsSymbols($params)).");";

		if ($returnQuery === false) {
			return $this->arrays($query, $params);
		} else {
			return $query;
		}

	}

	public function queryFromFile($filename, $params = array())
	{

		if (file_exists($filename)) {

			return $this->exec(utf8_decode(file_get_contents($filename)), false, $params);

		} else {

			throw new Exception("O arquivo {$filename} não existe.", 400);
		
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