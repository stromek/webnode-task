<?php
declare(strict_types=1);

namespace App\Mapper\OrderItem;

use App\Entity\Factory\OrderItemEntityFactory;
use App\Entity\OrderItemEntity;


class OrderItemMapperElastic extends \App\Mapper\MapperElastic {


  private OrderItemEntityFactory $factory;

  public function __construct(OrderItemEntityFactory $Factory) {
    $this->factory = $Factory;
  }

  public function createOrderEntity(array $response): OrderItemEntity {
    $Item = $this->factory->createOrderItem();

    $attributes = $response['_source'];
    // do smth with data
    $Item->id = $attributes['id'];
    $Item->name = $attributes['name'];
    // ...

    return $Item;
  }

}