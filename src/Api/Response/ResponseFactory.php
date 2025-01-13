<?php
declare(strict_types=1);

namespace App\Api\Response;

use App\Http\Enum\StatusCodeEnum;


class ResponseFactory {

  private \App\Api\Request\Request $request;


  public function __construct(\App\Api\Request\Request $httpRequest) {
    $this->request = $httpRequest;
  }


  public function create(mixed $payload, StatusCodeEnum $statusCodeEnum = StatusCodeEnum::STATUS_OK): ResponseInterface {
    $Filter = $this->createResponseFilter();

    return $this->createResponse(
      $statusCodeEnum,
      $Filter->transform($this->createResponseStructure(null, null, $payload)),
      $Filter->contentType(),
    );
  }


  public function createResponseFromXML(\App\Xml\XMLBuilder $XML, string $template, StatusCodeEnum $statusCodeEnum = StatusCodeEnum::STATUS_OK): ResponseInterface {
    return $this->createResponse($statusCodeEnum, $XML->xslTransform($template), "text/html");
  }


  public function createFromException(\Exception $Exception, StatusCodeEnum $statusCodeEnum = null): ResponseInterface {
    $Filter = $this->createResponseFilter();

    if(is_null($statusCodeEnum) AND $Exception instanceof \App\Interface\AppErrorInterface) {
      $statusCodeEnum = $Exception->getStatusCodeEnum();
    }

    return $this->createResponse(
      $statusCodeEnum ?? StatusCodeEnum::STATUS_INTERNAL_SERVER_ERROR,
      $Filter->transform($this->createResponseStructure($Exception->getCode(), $Exception->getMessage(), null)),
      $Filter->contentType(),
    );
  }


  public function createResponse(StatusCodeEnum $statusCodeEnum, string $body, string $contentType): ResponseInterface {
    return new Response(
      $statusCodeEnum,
      $body,
      ["Content-Type" => $contentType],
    );
  }


  private function createResponseFilter(): \App\Api\Response\Filter\ResponseFilterInterface {
    return \App\Api\Response\Filter\ResponseFilterFactory::create(
      strval($this->request->getQuery("format") ?? ""),
      $this->request->getHeaderLine("accept")
    );
  }


  /**
   * @return array{error: array{code: ?int, text: ?string}, payload: mixed}
   */
  private function createResponseStructure(?int $errCode, ?string $errMessage, mixed $responsePayload): array {
    $Structure = new ResponseBodyStructure($errCode, $errMessage, $responsePayload);

    return $Structure->create();
  }

}