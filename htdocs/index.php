<?php
declare(strict_types=1);

use App\Api\Router\Router;
use App\Env\AppEnv;
use Tracy\Debugger;

mb_internal_encoding("UTF-8");
date_default_timezone_set("UTC");

include './../vendor/autoload.php';

define("ROOT_DIR", realpath(__DIR__."/.."));
define("CONFIG_DIR", realpath(ROOT_DIR."/config"));
define("TMP_DIR", realpath(ROOT_DIR."/tmp"));
define("TEMPLATE_DIR", realpath(ROOT_DIR."/template"));


Debugger::$logDirectory = TMP_DIR;
Debugger::$strictMode = true;
//Debugger::enable(Debugger::Production);
Debugger::enable(Debugger::Development);

function vd(): void {
  Debugger::dump(func_get_args());
}

$Container = \App\Factory\ContainerFactory::create();

/** @var Router $Router */
$Router = $Container->get(Router::class);

/**
 * Chyba pro repository
 */
$Router->setErrorHandler(\App\Repository\RepositoryException::class, function(\App\Api\Request\Request $Request, \Exception $Exception) use ($Container): \App\Api\Response\ResponseInterface {
  return $Container->get(\App\Api\Response\ResponseFactory::class)->createFromException($Exception);
});

/**
 * @TODO autorizace a autentifikace, rozlišení scope...
 */

/**
 * Routa nenalezena, řeší routa "/*"
 */
//$Router->setErrorHandler(\App\Api\Router\RouterNotFoundException::class, function(\App\Api\Request\Request $Request, \Exception $Exception) use ($Container): \App\Api\Response\ResponseInterface {
//  return $Container->get(\App\Api\Response\ResponseFactory::class)->createFromException($Exception);
//});

/**
 * Všechny ostatní chyby
 */
$Router->setErrorHandler(\Exception::class, function(\App\Api\Request\Request $Request, \Exception $Exception) use ($Container): \App\Api\Response\ResponseInterface {
  if(AppEnv::displayInternalError()) {
    throw $Exception;
  }

  Debugger::tryLog($Exception, Debugger::EXCEPTION);
  return $Container->get(\App\Api\Response\ResponseFactory::class)->createFromException(
    new \App\Exception\AppException("Internal error.", 0, $Exception)
  );
});

$Router->get("/order/{id:[0-9]+}/", [\App\Controller\Order\OrderController::class, "detail"]);
$Router->get("/", [\App\Controller\Home\HomeController::class, "index"]);
$Router->get("/*", [\App\Controller\Home\HomeController::class, "error404"]);

$Router->run()->send();