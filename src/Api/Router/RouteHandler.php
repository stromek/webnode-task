<?php
declare(strict_types=1);


namespace App\Api\Router;


use App\Api\Response\ResponseInterface;


class RouteHandler {

  private \Closure|array|string $handler;


  public function __construct(callable $Handler) {
    $this->handler = $Handler;
  }
  

  public function __invoke(array $arguments): ResponseInterface {
    // @TODO dořešit varianty volání, pořadí argumentů, DI apod..
    return call_user_func_array($this->handler, array_values($arguments));
  }

}