<?php
declare(strict_types=1);

namespace App\Api\Request;

interface RequestInterface {

  public function getMethod(): \App\Http\Enum\MethodEnum;


  public function getUri(): \Psr\Http\Message\UriInterface;


  public function getQuery(string $key): null|string|array;

  
  public function getHeaderLine(string $header): string;
}