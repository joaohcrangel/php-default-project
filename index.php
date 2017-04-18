<?php

define('START_EXECUTION', microtime(true));

require_once("inc/configuration.php");

use Slim\Slim;
use Hcode\Permission;
use Hcode\Session;

Slim::registerAutoloader();

$app = new Slim();

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

$app->error(function (\Throwable $e) use ($app) {

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

$app->get("/info.php", function(){

    phpinfo();

});

$modules_path = __DIR__.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;

if (!is_dir($modules_path)) {
    mkdir($modules_path);
}

function require_files($path) {
    foreach (scandir($path) as $file) {
        if ($file !== '.' && $file !== '..') {
            if (is_dir($path.$file)) {
                require_files($path.$file);
            } else {
                global $app;
                require_once($path.$file);
            }
        }
    }
}

require_files($modules_path);

$app->run();

?>
