<?php
declare(strict_types=1);

namespace App\Mapper\Order;

class OrderMapperMySQL extends \App\Mapper\MapperMySQL {

  private \App\Entity\Factory\OrderEntityFactory $factory;

  
  public function __construct(\App\Entity\Factory\OrderEntityFactory $Factory) {
    $this->factory = $Factory;
  }


  public function createOrderEntity(\Dibi\Row $Row): \App\Entity\OrderEntity {
    // do smth with data
    $attributes = $Row->toArray();

    return $this->factory->createOrder($attributes);
  }


  public function createMySQLDataFromOrderEntity(\App\Entity\OrderEntity $Order): array {
    return $this->entityToDibiArray($Order);
  }

}