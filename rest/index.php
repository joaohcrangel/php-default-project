<?php

header('Content-Type: application/json');

require_once("../inc/configuration.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config('debug', false);

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

foreach (scandir(__DIR__."\\modules") as $file) {

	if($file !== '.' && $file !== '..'){
		require_once(__DIR__."\\modules\\".$file);
	}

}

$app->get('/', function () {
    echo "Welcome RestAPI";
});

$app->run();

?>