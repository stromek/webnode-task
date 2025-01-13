<?php
declare(strict_types=1);

namespace App\Mapper\OrderItem;

use App\Entity\Factory\OrderItemEntityFactory;
use App\Entity\OrderItemEntity;


class OrderItemMapperMySQL extends \App\Mapper\MapperMySQL {

  private OrderItemEntityFactory $factory;

  public function __construct(OrderItemEntityFactory $Factory) {
    $this->factory = $Factory;
  }


  public function createOrderItemEntity(\Dibi\Row $Row): OrderItemEntity {
    // do smth with data
    $attributes = $Row->toArray();

    return $this->factory->createOrderItem($attributes);
  }


  public function createMySQLDataFromOrderEntity(OrderItemEntity $Order): array {
    return $this->entityToDibiArray($Order);
  }

}