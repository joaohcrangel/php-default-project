<?php
if((float)PHP_VERSION < 5.3) require_once("functions-5-2.php");
function autoload($class){
	$filepath = __DIR__."/class/".strtolower($class).".php";
    if(file_exists($filepath)){
    	require_once($filepath);
    	return true;
    }
    $filepath = __DIR__."/class/objects/".strtolower($class).".php";
    if(file_exists($filepath)){
    	require_once($filepath);
    	return true;
    }
}
if(URL === "/inc/configuration.php"){
	phpinfo();
	exit;
}
function removeSimplesQuotes($val){
	return str_replace("'", "", $val);
}
function request($key){
	return removeSimplesQuotes($_REQUEST[$key]);
}
function r($key){
	return request($key);
}
function post($key){
	return removeSimplesQuotes($_POST[$key]);
}
function p($key){
	return post($key);
}
function get($key){
	return removeSimplesQuotes($_GET[$key]);
}
function g($key){
	return get($key);
}
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
function out($t){
	$t = base64_decode($t);	
	$len = substr($t, 0, 3);
	return requestFIT(base64_decode(substr($t, ($len+3), strlen($t)-($len+3))));
}
function pre(){
	echo "<pre>";
	foreach(func_get_args() as $arg){
		print_r($arg);
	}
	echo "</pre>";
}
function getClass($class_name){
	if(isset($_SESSION[$class_name])){
		return new $class_name($_SESSION[$class_name]);
	}else{
		throw new Exception("A classe $class_name não está em sessão");
	}
}
function setClass($class){
	$_SESSION[get_class($class)] = $class->getFields();
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
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
function ipinfo($ip = null){

	if($ip === null) $ip = $_SERVER['REMOTE_ADDR'];

	$result = file_get_contents('http://ipinfo.io/'.$ip.'/json');

	if(!$result){

		throw new Exception("Não foi possível conectar o servidor de IP.");

	}

	return json_decode($result, true);

}
function is_email($text){
	return (filter_var($text, FILTER_VALIDATE_EMAIL)===false)?false:true;
}
function is_ip($text){
	return (filter_var($text, FILTER_VALIDATE_IP)===false)?false:true;
}
define('KEY_ENCRYPT', 'PHP-DEFAULT-PROJECT-BY-JOAORANGEL');
function encrypt($data = array()){
	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, KEY_ENCRYPT, json_encode($data), MCRYPT_MODE_ECB));
}
function decrypt($data){
	return json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, KEY_ENCRYPT, base64_decode($data), MCRYPT_MODE_ECB)), true);
}
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
	$classpath = getClassPath().DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."PHPMailer".DIRECTORY_SEPARATOR;

	require_once($classpath."class.phpmailer.php");
	require_once($classpath."class.smtp.php");
	/************************************************************/
	$opt = array_merge(array(
		"username"=>"servweb",
		"password"=>"q1a2s3",
		//"Host"=>"172.17.2.5", IP antigo do servidor que o michel mudou por algum motivo D:
		"Host"=>"172.17.2.1",
		"SMTPAuth"=>true,
		"Port"=>25,
		"from"=>"servweb@impacta.com.br",
		"fromName"=>"Site Grupo Impacta Tecnologia",
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
	if($opt['embeddedImage']){
		foreach($opt['embeddedImage'] as $embeddedImage){
			if($embeddedImage['path'] && $embeddedImage['id'])
			$mail->AddEmbeddedImage($embeddedImage['path'],$embeddedImage['id']);
		}	
	}

	if($opt['CharSet']) $mail->CharSet = $opt['CharSet'];
	
	$mail->Priority = $opt['priority'];
	
	$mail->SetFrom($opt['from'], $opt['fromName']);
	
	if($opt['reply']) $mail->AddReplyTo($opt['reply'],$opt['replayName']);
	
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
function getObjectFromSession($object){

	$obj = new $object($_SESSION[$object]);

	if(isset($_SESSION[$object])){
		return new $object($_SESSION[$object]);
	}else{
		return new $object();
	}

}
function setObjectInSession($object){

	return $_SESSION[get_class($object)] = $object->getFields();

}
function setLocalCookie($name, $data, $time){
	setcookie($name, encrypt($data), time()+$time, "/", $_SERVER['SERVER_NAME'], 1);
}
function getLocalCookie($name){
	$data = $_COOKIE[$name];
	if($data!==NULL && strlen($data)>0){
		return decrypt($data);
	}else{
		return false;
	}
}
?>