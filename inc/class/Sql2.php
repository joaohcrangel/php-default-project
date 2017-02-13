<?php 

class Sql extends PDO {

	private $conn;
	private $utf8 = true;

	public function __construct()
	{

		$this->conn = new PDO('mysql:host='.$this->server.';dbname='.$this->database, $this->username, $this->password);

    	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

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

	}

}

?>