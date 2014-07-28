<?php
/**
* Classe de Banco de Dados com conexão e métodos para cadastro, alteração e exclusão dinâmicos
* @package Sql
*/
class Sql{
  
	public $conn;
	
	private $server = 'localhost';
	private $username = '';
	private $password = '';
	private $database = '';
	
	/*********************************************************************************************************/	
	/**
	* Método usado para abrir o banco de dados com os atributos private supradeclarados
	* @metodo conecta
	*/	
	public function conecta(){
		
		return $this->conn = mysqli_connect($this->server, $this->username, $this->password, $this->database);
			
	}
	/*********************************************************************************************************/	
	/**
	* Método Construtor que chama o método conecta() para abrir o banco de dados
	* @metodo __construct
	*/	
	public function __construct(){
		
		return $this->conecta();
			
	}
	/*********************************************************************************************************/	
	/**
	* Método destrutor que fecha a conexão previamente aberta
	* @metodo __destruct
	*/	
	public function __desconstruct(){
		
		return mysqli_close($this->conn);
			
	}
	/*********************************************************************************************************/	
	/**
	* Método que executa qualquer instrução no banco de dados em uso
	* @metodo query
	*/	
	public function query($query){
		
		$this->conecta();
		return mysqli_query($this->conn, $query);
			
	}
	
	/*********************************************************************************************************/	
	/**
	* Método que retorna um registro fatiado em array
	* @metodo query
	*/	
	public function select($query){
		
		return $this->arrays($query, true);
			
	}
	
	/*********************************************************************************************************/	
	/**
	* Método que retorna o último ID gerado
	* @metodo query
	*/	
	public function id(){
		
		return mysqli_insert_id($this->conn);
			
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
	/*********************************************************************************************************/	
	/**
	* Método que recebe uma query como parâmetro executa esta query guardando o resultado na variável local $a.
	* Cria uma variável $fields do tipo array que irá armazenar todos os campos da query em questão por meio do resultado da função fetch_fields(), usando um forech ele armazenará o nome do campo, seu datatype e quantos caracteres são permitidos nesse campo.
	*Cria uma variável $data do tipo array que irá armazenar o retorno dos dados obtidos pela query, antes porém ela executa um foreach para formatar os campos datetime, decimal e money no padrão americano e tirando espaços para os demais tipos. alimenta o array $data com os registros formatados em $record.
	* @metodo arrays
	*/	
	public function arrays($query, $array = false){
		
		$a = $this->query($query);	
		$fields = array();
		
		$finfo = $a->fetch_fields();

	    foreach($finfo as $val){
			
			array_push($fields, array(
				"field"=>$val->name,
				"type"=>strtoupper($val->type),
				"max_length"=>$val->max_length
			));
			
		}
		
		$data = array();
		
		while($a1 = $a->fetch_array()){
			
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
					$record[$f['field']] = utf8_encode(trim($a1[$f['field']]));
					break;
				}
					
			}
			
			array_push($data, $record);
				
		}
		
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
		
}
?>
