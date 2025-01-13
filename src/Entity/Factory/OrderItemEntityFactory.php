<?php
declare(strict_types=1);

namespace App\Entity\Factory;


use App\Entity\OrderItemEntity;


class OrderItemEntityFactory extends EntityFactory {

  public function createOrderItem(array $attributes = []): OrderItemEntity {
    $Item = new OrderItemEntity();

    $this->setAttributes($Item, $attributes);

    return $Item;
  }

}