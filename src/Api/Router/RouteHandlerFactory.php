<?php
declare(strict_types=1);


namespace App\Api\Router;

class RouteHandlerFactory {

  private \DI\Container $container;

  public function __construct(\DI\Container $container) {
    $this->container = $container;
  }
  

  public function createHandler(callable|array $handler): RouteHandler {
    // Non-static object call
    if(is_array($handler) AND !is_callable($handler)) {
      if(!class_exists($handler[0])) {
        throw new RouteHandlerFactoryException("Class '{$handler[0]}' does not exist");
      }

      return new RouteHandler([$this->container->get($handler[0]), $handler[1]]);
    }

    return new RouteHandler($handler);
  }

}