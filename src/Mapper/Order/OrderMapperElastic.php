<?php
declare(strict_types=1);

namespace App\Mapper\Order;

use App\Entity\Factory\OrderEntityFactory;


class OrderMapperElastic extends \App\Mapper\MapperElastic {


  private OrderEntityFactory $factory;

  public function __construct(OrderEntityFactory $Factory) {
    $this->factory = $Factory;
  }
  

  public function createOrderEntity(array $response): \App\Entity\OrderEntity {
    $Order = $this->factory->createOrder();

    $attributes = $response['_source'];
    // do smth with data
    $Order->id = $attributes['id'];
    $Order->name = $attributes['name'];


    return $Order;
  }

}