<?php
function autoload_php_default_project($class){

	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

	$filepath = __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR.$class.".php";
    if(file_exists($filepath)){
    	require_once($filepath);
    	return true;
    }
    $filepath = __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."objects".DIRECTORY_SEPARATOR.$class.".php";

    if(file_exists($filepath)){
    	require_once($filepath);
    	return true;
    }
    $filepath = __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR.$class.".php";

    if(file_exists($filepath)){

    	require_once($filepath);
    	return true;

    }elseif(file_exists(__DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php")){

    	require_once(__DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php");
    	return true;

    }else{

    	throw new Exception("Classe não encontrada em: ".$filepath, 400);	

    }
}
if(URL === "/inc/configuration.php"){
	phpinfo();
	exit;
}
if(!function_exists('removeSimplesQuotes')){
	function removeSimplesQuotes($val){
		return str_replace("'", "", $val);
	}
}
if(!function_exists('request')){
	function request($key){
		return (isset($_REQUEST[$key]))?removeSimplesQuotes($_REQUEST[$key]):NULL;
	}
}
if(!function_exists('r')){
	function r($key){
		return request($key);
	}
}
if(!function_exists('post')){
	function post($key){
		return (isset($_POST[$key]))?removeSimplesQuotes($_POST[$key]):NULL;
	}
}
if(!function_exists('p')){
	function p($key){
		return post($key);
	}
}
if(!function_exists('get')){
	function get($key){
		return (isset($_GET[$key]))?removeSimplesQuotes($_GET[$key]):NULL;
	}
}
if(!function_exists('g')){
	function g($key){
		return get($key);
	}
}
if(!function_exists('in')){
	function in($t, $arrays = true, $keyEncode=''){
		if(is_array($t)){
			if($arrays){
				$b = array();
				foreach($t as $i){
					$n = array();
					foreach($i as $k=>$v){
						$n[chgName($k)] = $v;
					}
					$n['_'.chgName($keyEncode)] = in($i[$keyEncode]);
					array_push($b, $n);
				}
				return $b;
			}else{
				$n = array();
				foreach($t as $k=>$v){
					$n[chgName($k)] = $v;
				}
				$n['_'.chgName($keyEncode)] = in($t[$keyEncode]);
				return $n;
			}
		}else{
			$encode = base64_encode(time());
			return base64_encode(str_pad(strlen($encode), 3, '0', STR_PAD_LEFT).$encode.base64_encode($t));
		}
	}
}
if(!function_exists('out')){
	function out($t){
		$t = base64_decode($t);	
		$len = substr($t, 0, 3);
		return requestFIT(base64_decode(substr($t, ($len+3), strlen($t)-($len+3))));
	}
}
if(!function_exists('pre')){
	function pre(){
		echo "<pre>";
		foreach(func_get_args() as $arg){
			print_r($arg);
		}
		echo "</pre>";
	}
}
if(!function_exists('getClass')){
	function getClass($class_name){
		if(isset($_SESSION[$class_name])){
			return new $class_name($_SESSION[$class_name]);
		}else{
			throw new Exception("A classe $class_name não está em sessão");
		}
	}
}
if(!function_exists('setClass')){
	function setClass($class){
		$_SESSION[get_class($class)] = $class->getFields();
	}
}
if(!function_exists('array_sort_by_column')){
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	    $sort_col = array();
	    foreach ($arr as $key=> $row) {
	        $sort_col[$key] = $row[$col];
	    }

	    array_multisort($sort_col, $dir, $arr);
	}
}
if(!function_exists('abreviateTotalCount')){
	function abreviateTotalCount($value){

	    $abbreviations = array(12 => 't', 9 => 'b', 6 => 'm', 3 => 'k', 0 => '');

	    foreach($abbreviations as $exponent => $abbreviation) 
	    {

	        if($value >= pow(10, $exponent)) 
	        {

	            return round(floatval($value / pow(10, $exponent)),1).$abbreviation;

	        }

	    }

	}
}
if(!function_exists('ipinfo')){
	function ipinfo($ip = null){

		if($ip === null) $ip = $_SERVER['REMOTE_ADDR'];

		$result = file_get_contents('http://ipinfo.io/'.$ip.'/json');

		if(!$result){

			throw new Exception("Não foi possível conectar o servidor de IP.");

		}

		return json_decode($result, true);

	}
}
if(!function_exists('is_email')){
	function is_email($text){
		return (filter_var($text, FILTER_VALIDATE_EMAIL)===false)?false:true;
	}
}
if(!function_exists('is_ip')){
	function is_ip($text){
		return (filter_var($text, FILTER_VALIDATE_IP)===false)?false:true;
	}
}
if(!function_exists('encrypt')){
	function encrypt($data = array()){
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, KEY_ENCRYPT, json_encode($data), MCRYPT_MODE_ECB));
	}
}
if(!function_exists('decrypt')){
	function decrypt($data){
		return json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, KEY_ENCRYPT, base64_decode($data), MCRYPT_MODE_ECB)), true);
	}
}
if(!function_exists('send_email')){
	function send_email($options, $tplname = "blank", $data = array(""), $comTemplatePadrao = true){

		/************************************************************/
		if(isset($options['body'])) $data['body'] = $options['body'];

		if(isset($_SESSION)) $data['data']['session'] = $_SESSION;
		if(isset($_SERVER)) $data['data']['server'] = $_SERVER;

		raintpl::configure("base_url", PATH );
		raintpl::configure("tpl_dir", PATH."/res/tpl/email/" );
		raintpl::configure("cache_dir", PATH."/res/tpl/tmp/" );
		raintpl::configure("path_replace", false );

		$tpl = new RainTPL;

		if(gettype($data)=='array'){
			foreach($data as $key=>$val){
				$tpl->assign($key, $val);
			}
		}	

		$body = "";
		if($comTemplatePadrao === true) $body .= $tpl->draw("header", true);
		$body .= $tpl->draw($tplname, true);
		if($comTemplatePadrao === true) $body .= $tpl->draw("footer", true);

		$options['body'] = $body;
		/************************************************************/
		$classpath = PATH.DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."phpmailer".DIRECTORY_SEPARATOR."phpmailer".DIRECTORY_SEPARATOR;

		require_once($classpath."class.phpmailer.php");
		require_once($classpath."class.smtp.php");
		/************************************************************/
		$opt = array_merge(array(
			"username"=>"",
			"password"=>"",
			"Host"=>"",
			"SMTPAuth"=>true,
			"Port"=>25,
			"from"=>"",
			"fromName"=>"",
			"reply"=>false,
			"replayName"=>false,
			"AltBody"=>"Por favor, utilize um visualizador de e-mail compátivel com HTML para visuliazar esta mensagem.",
			"to"=>array(),
			"cc"=>array(),
			"cco"=>array(),
			"priority"=>3,
			"subject"=>"",
			"CharSet"=>"UTF-8"
		), $options);
		
		$mail             = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host       = $opt['Host'];
		$mail->IsHTML();
		$mail->SMTPAuth   = $opt['SMTPAuth'];
		$mail->Port       = $opt['Port'];
		$mail->Username   = $opt['username'];
		$mail->Password   = $opt['password'];

		//$mail->SMTPSecure = "tls";
		if(isset($opt['embeddedImage'])){
			foreach($opt['embeddedImage'] as $embeddedImage){
				if($embeddedImage['path'] && $embeddedImage['id'])
				$mail->AddEmbeddedImage($embeddedImage['path'],$embeddedImage['id']);
			}	
		}

		if(isset($opt['CharSet'])) $mail->CharSet = $opt['CharSet'];
		
		$mail->Priority = $opt['priority'];
		
		$mail->SetFrom($opt['from'], $opt['fromName']);
		
		if(isset($opt['reply'])) $mail->AddReplyTo($opt['reply'],$opt['replayName']);
		
		$mail->Subject    = $opt['subject'];
		
		$mail->AltBody    = $opt['AltBody'];
		
		$mail->MsgHTML($opt['body']);
		
		if(is_array($opt['to'])){
			foreach($opt['to'] as $to){
				$mail->AddAddress($to['email'], $to['name']);
			}
		}else{
			foreach(explode(';', $opt['to']) as $email){
				$mail->AddAddress($email);
			}
		}
		
		if(is_array($opt['cc'])){
			foreach($opt['cc'] as $to){
				$mail->AddCC($to['email'], $to['name']);
			}
		}else{
			foreach(explode(';', $opt['cc']) as $email){
				$mail->AddCC($email);
			}
		}

		if(is_array($opt['cco'])){
			foreach($opt['cco'] as $to){
				$mail->AddBCC($to['email'], $to['name']);
			}
		}else{
			foreach(explode(';', $opt['cco']) as $email){
				$mail->AddBCC($email);
			}
		}
		
		if(!$mail->Send()){
		  return false;
		} else {
		  return true;
		}
		
	}
}
if(!function_exists('setUrl')){
	function setUrl($name, $value, $url = NULL){

		if(!$url){
			$qs = $_SERVER['QUERY_STRING'];
		}else{
			$qs = end(explode('?', $url));
		}

		$params = explode('&', $qs);
		$paramsNew = array();

		foreach ($params as &$p) {
			
			$var = explode('=', $p);
				
			if($name !== $var[0] && $var[0]){
				array_push($paramsNew, $var[0].'='.$var[1]);
			}

		}

		if($value!==false) array_push($paramsNew, $name.'='.$value);

		$url = URL_REQUEST;

		$url = explode('?', $url);

		return $url[0].'?'.implode('&', $paramsNew);

	}
}
if(!function_exists('getObjectFromSession')){
	function getObjectFromSession($object){

		if(isset($_SESSION[$object])){
			return new $object($_SESSION[$object]);
		}else{
			return new $object();
		}

	}
}
if(!function_exists('setObjectInSession')){
	function setObjectInSession($object){
		return $_SESSION[get_class($object)] = $object->getFields();
	}
}
if(!function_exists('setLocalCookie')){
	function setLocalCookie($name, $data, $time){
		setcookie($name, encrypt($data), (int)(time()+$time), "/", $_SERVER['SERVER_NAME'], 1);
	}
}
if(!function_exists('getLocalCookie')){
	function getLocalCookie($name){
		if (!isset($_COOKIE[$name])) return false;
		$data = $_COOKIE[$name];
		if($data!==NULL && strlen($data)>0){
			return decrypt($data);
		}else{
			return false;
		}
	}
}
if(!function_exists('unsetLocalCookie')){
	function unsetLocalCookie($name){
		if(isset($_COOKIE[$name])) unset($_COOKIE[$name]);
		setcookie($name, null, -1, "/");
	}
}
if(!function_exists('success')){
	function success($data = array()){



		$json = json_encode(array_merge(array(
			'success'=>true,
			'delay'=>microtime(true)-START_EXECUTION
		), $data));

		if(isset($_GET['callback'])){
			return get('callback').'('.$json.')';
		}elseif(isset($_GET['jsonp'])){
			return get('jsonp').'('.$json.')';
		}else{
			return $json;
		}

	}
}
if(!function_exists('array_merge_recursive_distinct')){
function array_merge_recursive_distinct ( array &$array1, array &$array2 ){
  $merged = $array1;

  foreach ( $array2 as $key => &$value )
  {
    if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
    {
      $merged [$key] = array_merge_recursive_distinct ( $merged [$key], $value );
    }
    else
    {
      $merged [$key] = $value;
    }
  }

  return $merged;
}
}
if(!function_exists('echoMenuHTML')){
function echoMenuHTML(){
    echo Hcode\Admin\Menu::getMenuSession();
}
}
if(!function_exists('echoSiteMenuHTML')){
function echoSiteMenuHTML(){
    echo Hcode\Site\Menu::getMenuSession();
}
}
if(!function_exists('isLogged')){
function isLogged(){
	$user = Hcode\Session::getUser();
	return $user->isLogged();
}
}
function file_upload_max_size() {
  static $max_size = -1;

  if ($max_size < 0) {
    // Start with post_max_size.
    $max_size = parse_size(ini_get('post_max_size'));

    // If upload_max_size is less, then reduce. Except if upload_max_size is
    // zero, which indicates no limit.
    $upload_max = parse_size(ini_get('upload_max_filesize'));
    if ($upload_max > 0 && $upload_max < $max_size) {
      $max_size = $upload_max;
    }
  }
  return $max_size;
}

function parse_size($size) {
  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
  if ($unit) {
    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
  }
  else {
    return round($size);
  }
}
function getUserJSON(){
	return Hcode\Session::getUser()->toJSON();
}
function getPersonJSON(){
	return Hcode\Session::getPerson()->toJSON();
}
?>