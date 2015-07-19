<?php

define('START_EXECUTION', microtime(true));

require_once("../inc/configuration.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config('debug', true);

$app->error(function (\Exception $e) use ($app) {

    echo json_encode(array(
        'success'=>false,
        'error'=>$e->getMessage(),
        'errorcode'=>$e->getCode(),
        'errorfile'=>$e->getFile(),
        'errorline'=>$e->getLine()
    ));

});

$app->notFound(function () use ($app) {
    
	echo json_encode(array(
        'success'=>false,
        'error'=>'Esta rota não existe.'
    ));

});

$app->get("/", function(){

	echo "RESTful API";

});

$modules_path = __DIR__."\\modules\\";

foreach (scandir($modules_path) as $file) {

	if ($file !== '.' && $file !== '..') {
		require_once($modules_path.$file);
	}

}

$app->run();

?>