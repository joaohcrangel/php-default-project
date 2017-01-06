<?php
/**
* Classe de Banco de Dados com conexão e métodos para cadastro, alteração e exclusão dinâmicos
* @package Sql
*/
class Sql {

	public $conn;

	const MYSQL = 1;
	const SQLSERVER = 2;

	private $type = DB_TYPE;

	private $server = DB_HOST;
	private $username = DB_USER;
	private $password = DB_PASSWORD;
	private $database = DB_NAME;

	private $utf8 = true;
	private $sessionLog = true;

	/*********************************************************************************************************/
	/**
	* Método usado para abrir o banco de dados com os atributos private supradeclarados
	* @metodo conecta
	*/
	public function conecta($config = array()){

		try {

			if(count($config)){

				$this->server = $config['server'];
				$this->username = $config['username'];
				$this->password = $config['password'];
				$this->database = $config['database'];

			}

			switch($this->type){

				case Sql::MYSQL:
				return $this->conectaMySQL();
				break;

				case Sql::SQLSERVER:
				return $this->conectaSQLServer();
				break;

			}

		} catch (Exception $e) {

			var_dump($e->getMessage(), $e);

			// header("location: ".SITE_PATH."/modules/install");

		}

	}

	public function getType(){

		return (int)$this->type;

	}

	public function getDataTypes(){

		switch ($this->type) {
			case Sql::MYSQL:
				return array(
		    		"BIGINT",
		    		"DECIMAL",
		    		"DOUBLE",
		    		"FLOAT",
		    		"INT",
		    		"MEDIUMINT",
		    		"SMALLINT",
		    		"TINYINT",

		    		"CHAR",
		    		"VARCHAR",

		    		"DATE",
		    		"DATETIME",
		    		"TIME",
		    		"TIMESTAMP",
		    		"YEAR",

		    		"TEXT",
		    		""
		    	);
				break;

			case Sql::SQLSERVER:
				return array();
				break;
		}

	}

	private function conectaMySQL(){

		$this->conn = @mysqli_connect($this->server, $this->username, $this->password);

		if(!$this->conn){

			throw new Exception("Não foi possível conectar com o servidor de banco de dados.");

		}

		if(!@mysqli_select_db($this->conn, $this->database)) {

			throw new Exception("O banco de dados ".$this->database." não foi encontrado. ".mysqli_error($this->conn));

		}

		return $this->conn;

	}

	private function conectaSQLServer(){

		$connInfo = array(
			"Database"=>$this->database,
			"UID"=>$this->username,
			"PWD"=>$this->password
		);
		$this->conn = sqlsrv_connect($this->server, $connInfo);

		if(!$this->conn){

			die(print_r(sqlsrv_errors()));

		}

		return $this->conn;

	}
	/*********************************************************************************************************/
	/**
	* Método Construtor que chama o método conecta() para abrir o banco de dados
	* @metodo __construct
	*/
	public function __construct(){

		if($this->database !== 'database_name_here'){

			return $this->conecta();

		}

	}
	/*********************************************************************************************************/
	/**
	* Método destrutor que fecha a conexão previamente aberta
	* @metodo __destruct
	*/
	public function __desconstruct(){

		switch($this->type){

			case Sql::MYSQL:
			return mysqli_close($this->conn);
			break;

			case Sql::SQLSERVER:
			return sqlsrv_close($this->conn);
			break;

		}

	}
	/*********************************************************************************************************/
	/**
	* Método que executa várias instruções no banco de dados
	* @metodo querys
	*/
	public function querys($querys = array(), $params = array()){

		$p = array();

		foreach($params as $param){

			foreach($param as $val){

				array_push($p, $val);

			}

		}

		$this->query(implode(";",$querys), $p, true);

		$results = array();

		switch($this->type){

			case Sql::MYSQL:

				do{

					if ($result = mysqli_store_result($this->conn)) {

			            array_push($results, $this->getArrayRows($result));

			            mysqli_free_result($result);
			        }

		    	}while(mysqli_more_results($this->conn) && mysqli_next_result($this->conn));

		    break;

		    case Sql::SQLSERVER:

		    throw new Exception("Pendente");

		    break;

		}

		return $results;

	}

	public function queryFromFile($filename, $params = array()){

		if (file_exists($filename)) {

			return $this->query(file_get_contents($filename), $params);

		} else {
			throw new Exception("O arquivo {$filename} não existe.", 400);
		}

	}
	/*********************************************************************************************************/
	/**
	* Método que executa qualquer instrução no banco de dados em uso
	* @metodo query
	*/
	public function query($query, $params = array(), $multi = false){

		$this->conecta();

		if(count($params)){

			$query = str_replace('?','{?}', $query);
			$query = $this->setParamsToQuery($query, $this->trataParams($params));

		}

		if ($_SERVER['HTTP_HOST'] === 'locahost' && isset($_GET['query-debug'])) pre($query);

		try{

			if ($this->sessionLog === true) {
				if (!isset($_SESSION['querys']) || gettype($_SESSION['querys']) !== 'array') {
					$_SESSION['querys'] = array();
				}

				array_push($_SESSION['querys'], array(
					'query'=>$query,
					'date'=>date('Y-m-d H:i:s')
				));
			}

			switch($this->type){

				case Sql::MYSQL:
				if($multi === false){
					$resource = mysqli_query($this->conn, $query);
				}else{
					$query = str_replace(';;', ';', $query);
					$resource = mysqli_multi_query($this->conn, $query);

				}
				break;

				case Sql::SQLSERVER:
				if($multi === false){
					$resource = sqlsrv_query($this->conn, $query);
				}else{

					$queryFinal = array();
					$paramFinal = array();

					for ($i = 0; $i < count($querys); $i++) {

						$query = $querys[$i];
						$param = $this->trataParams($params[$i]);

						$st = sqlsrv_prepare($this->conn, $query, $param);

						if(!$st){

							die(print_r(sqlsrv_errors(), true));

						}else{

							array_push($queryFinal, $query);

							foreach ($param as $p) {
								array_push($paramFinal, $p);
							}

						}

					}

					$results = array();

					$r = $this->query(implode("; ", $queryFinal), $paramFinal);

					if(!$r){

						die(print_r(sqlsrv_errors(), true));

					}

					$row = sqlsrv_fetch_array($r, SQLSRV_FETCH_ASSOC);
					array_push($results, $row);

					while($result = sqlsrv_next_result($r)){

						$row = sqlsrv_fetch_array($r, SQLSRV_FETCH_ASSOC);
						array_push($results, $row);

					}

					return $results;

				}
				break;

			}

		}catch(Exception $e){

			 var_dump($e, debug_backtrace());

		}

		if(!isset($resource) || !$resource){

			switch($this->type){

				case Sql::MYSQL:
				var_dump(mysqli_error($this->conn), debug_backtrace());
				break;

				case Sql::SQLSERVER:
				var_dump(sqlsrv_errors(), debug_backtrace());
				break;

			}

		}

		return $resource;

	}

	private function setParamsToQuery($query, $params = array()){

		if(strpos($query, '{?}')>-1 && count($params) > 0){

			$first = preg_quote(array_shift($params));
			$query = preg_replace('/\{\?\}/', $first, $query, 1);

			return $this->setParamsToQuery($query, $params);

		}else{

			return $query;

		}

	}

	public function trataParams($params = array()){

		$params_new = array();

		foreach ($params as $value) {

			switch(strtolower(gettype($value))){
				case 'string':
			
				$value = ($this->utf8 === true)?utf8_decode($value):$value;
				
				array_push($params_new, "'".$value."'");
				break;
				case 'integer':
				case 'float':
				case 'double':
				array_push($params_new, $value);
				break;
				case 'bool':
				case 'boolean':
				array_push($params_new, (($value)?1:0));
				break;
				case 'null':
				array_push($params_new, 'NULL');
				break;
				default:
				array_push($params_new, "''");
				break;
			}

		}

		return $params_new;

	}

	/*********************************************************************************************************/
	/**
	* Método que retorna um registro fatiado em array
	* @metodo query
	*/
	public function select($query, $params = array()){

		return $this->arrays($query, true, $params);

	}
	/*********************************************************************************************************/
	/**
	* Método que recebe o nome da tabela como parâmetro cria uma consulta para retornar todos os campos de uma tabela com seus respectivos datatypes. Transforma esse resultado em um array e retorna este array
	* @metodo fields
	*/
	public function fields($table){

		$fields = array();

		$result = $this->query("SHOW COLUMNS FROM tbl_".strtolower($table));

		while($row = $result->fetch_object()){

			array_push($fields, $row);

		}

		return $fields;

	}

	private function getFieldsFromResouce($resource){

		$fields = array();

		switch($this->type){

			case SQL::MYSQL:
			if(gettype($resource) === 'object'){
				$finfo = $resource->fetch_fields();
			    foreach($finfo as $val){
					array_push($fields, array(
						"field"=>$val->name,
						"type"=>strtoupper($val->type),
						"max_length"=>$val->max_length
					));
				}
			}
			break;

			case SQL::SQLSERVER:
			foreach(sqlsrv_field_metadata($resource) as $field){
				array_push($fields, array("field"=>$field['Name'], "type"=>strtoupper($field['Type']), "max_length"=>$field['Size']));
			}
			break;

		}

		return $fields;

	}

	public function getArrayRows($resource){

		$fields = $this->getFieldsFromResouce($resource);

		$data = array();

		switch($this->type){

			case SQL::SQLSERVER:

				while($a1 = sqlsrv_fetch_array($resource)){
		            $record = array();
		            foreach($fields as $f) {

		                switch ((int)$f['type']) {
							case 4:
								$record[$f['field']] = (int)($a1[$f['field']]);
								break;
							case -6:
								$record[$f['field']] = (int)($a1[$f['field']]);
								break;
							case 3:
								$record[$f['field']] = (float)($a1[$f['field']]);
								break;
							case 16:
								$record[$f['field']] = (int)($a1[$f['field']]);
								break;
							case 20:
								$record[$f['field']] = (float)($a1[$f['field']]);
								break;
							case 11:
								$record[$f['field']] = (bool)($a1[$f['field']]);
								break;
							case -7:
								$record[$f['field']] = (bool)($a1[$f['field']]);
								break;
							case 6:
								$record[$f['field']] = (float)number_format($a1[$f['field']], 2, '.', '');
								break;
							case 14:
								$record[$f['field']] = (float)number_format($a1[$f['field']], 2, '.', '');
								break;
							case -154:
								if($datetime){
									$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]:NULL;
								}else{
									$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]->format('H:i:s'):NULL;
								}
								$record["des".$f['field']] = date("d/m/Y H:i", strtotime($record[$f['field']]));
							break;
							case 7:
								if($datetime){
									if($datasql){
										$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]->format('Y-m-d H:i'):NULL;
									}else{
										$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]:NULL;
									}
								}else{
									$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]->format('U'):NULL;
								}
								$record["des".$f['field']] = date("d/m/Y H:i", $record[$f['field']]);
							break;
							case 93:
								if($datetime){
									if($datasql){
										$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]->format('Y-m-d H:i'):NULL;
										$record["des".$f['field']] = date("d/m/Y", strtotime($record[$f['field']]));
									}else{
										$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]:NULL;
									}
								}else{
									$record[$f['field']] = ($a1[$f['field']])?$a1[$f['field']]->format('U'):NULL;
									$record["des".$f['field']] = date("d/m/Y", $record[$f['field']]);
								}
							break;
							case 12:
								$record[$f['field']] = trim(utf8_encode(trim($a1[$f['field']])));
								break;
							case 91:
								$record[$f['field']] = strtotime($a1[$f['field']]->format('Y-m-d H:i:s'));
								break;
							default:
								$record[$f['field']] = trim(utf8_encode(trim($a1[$f['field']])));
								break;
							}
		            }
		            if(is_array($record)) array_push($data, $record);
		        }

			break;

			case SQL::MYSQL:

				while(gettype($resource) === 'object' && $a1 = $resource->fetch_array()){

					$record = array();

					foreach($fields as $f){

						switch($f['type']){
							case 'DATETIME':
							$record[$f['field']] = strtotime(formatdatetime($a1[$f['field']],8));
							break;
							case 'MONEY':
							$record[$f['field']] = number_format($a1[$f['field']],2,'.','');
							break;
							case 'DECIMAL':
							$record[$f['field']] = number_format($a1[$f['field']],2,'.','');
							break;
							default:
							$value = ($this->utf8 === true)?utf8_encode(trim($a1[$f['field']])):trim($a1[$f['field']]);
							$record[$f['field']] = $value;
							unset($value);
							break;
						}

					}

					array_push($data, $record);

				}

			break;

		}

		return $data;

	}

	/*********************************************************************************************************/
	/**
	* Método que recebe uma query como parâmetro executa esta query guardando o resultado na variável local $a.
	* Cria uma variável $fields do tipo array que irá armazenar todos os campos da query em questão por meio do resultado da função fetch_fields(), usando um forech ele armazenará o nome do campo, seu datatype e quantos caracteres são permitidos nesse campo.
	*Cria uma variável $data do tipo array que irá armazenar o retorno dos dados obtidos pela query, antes porém ela executa um foreach para formatar os campos datetime, decimal e money no padrão americano e tirando espaços para os demais tipos. alimenta o array $data com os registros formatados em $record.
	* @metodo arrays
	*/
	public function arrays($query, $array = false, $params = array()){

		$data = $this->getArrayRows($this->query($query, $params));

		if(!$array){
			return $data;
		}else{
			if(count($data)==1 && $array){
				return $data[0];
			}else{
				return $data;
			}
		}

	}

	public function objects($query, $array = true, $params = array()){
		$data = $this->arrays($query, $array, $params);
		foreach($data as &$a){
			$a = (object)$a;
		}
		return $data;
	}

	public function insert($query, $params = array()){

		return $this->select($query, $params);

	}

	public function proc($name, $params = array(), $returnQuery = false){

		switch($this->getType()){

			case Sql::MYSQL:
			$i = array();
			foreach ($params as $p) {
				array_push($i, "?");
			}
			$query = "CALL ".$name."(".implode(", ", $i).");";
			break;

			case Sql::SQLSERVER:
			$i = array();
			foreach ($params as $p) {
				array_push($i, "?");
			}
			$query = "EXEC ".$name." ".implode(", ", $i);
			break;

		}

		if($returnQuery === false){
			return $this->arrays($query, false, $params);
		}else{
			return $query;
		}

	}

	public function getDataBases(){

		$rows = array();
		foreach ($this->arrays("SHOW DATABASES") as $row) {
			array_push($rows, $row["Database"]);
		}
		return $rows;

	}

	public function getTables($database){

		$rows = array();
		foreach($this->arrays("SHOW TABLES FROM $database") as $row){
			array_push($rows, $row["Tables_in_$database"]);
		}
		return $rows;

	}

}
if (isset($_SESSION['querys'])) unset($_SESSION['querys']);
?>
