<?php
declare(strict_types=1);

namespace App\Api\Response\Transformer;


/**
 * @TODO definovat více transformaci pro různá verze API nebo použití
 */
class OrderResponseTransformer {

  /**
   * @TODO použí pevnou strukturu jako ["id" => $Order->id..], nikoliv jsonSerialize()/toArray() pro zachování kompatibiliy v rámci různých verzích API
   */
  public function transform(\App\Entity\OrderEntity $Order): array {
    return array_merge(
      $Order->jsonSerialize(),
      ["itemCount" => count($Order->getItems())]
    );
  }
}