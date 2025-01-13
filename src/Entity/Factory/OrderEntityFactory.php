<?php
declare(strict_types=1);

namespace App\Entity\Factory;


use App\Entity\OrderEntity;


class OrderEntityFactory extends EntityFactory {

  public function createOrder(array $attributes = [], array $orderItems = []): OrderEntity {
    $Order = new OrderEntity();

    $this->setAttributes($Order, $attributes);

    foreach($orderItems as $OrderItem) {
      $Order->addItem($OrderItem);
    }

    return $Order;
  }

}