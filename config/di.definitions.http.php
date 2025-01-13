<?php
declare(strict_types=1);

return [
  \GuzzleHttp\Psr7\Request::class => function () {
    $headers = [];
    foreach ($_SERVER ?? [] as $key => $value) {
      if(str_starts_with($key, 'HTTP_')) {
        $headerName = str_replace('_', '-', substr($key, 5));
        $headers[$headerName] = $value;
      }
    }

    return new \GuzzleHttp\Psr7\Request(
      filter_input(INPUT_SERVER, "REQUEST_METHOD"),
      filter_input(INPUT_SERVER, "REQUEST_URI") ?? "/",
      $headers,
      file_get_contents('php://input')
    );
  },

  \App\Api\Request\RequestInterface::class => DI\autowire(\App\Api\Request\Request::class),
  \App\Api\Response\ResponseInterface::class => DI\autowire(\App\Api\Response\Response::class),
];