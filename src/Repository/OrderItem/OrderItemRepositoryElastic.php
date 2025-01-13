<?php
declare(strict_types=1);

namespace App\Repository\OrderItem;

class OrderItemRepositoryElastic extends \App\Repository\RepositoryElastic implements OrderItemRepositoryInterface {

  private OrderItemFactory $orderFactory;

  public function __construct(\Elastic\Elasticsearch\Client $client, OrderItemFactory $OrderFactory) {
    parent::__construct($client);
    
    $this->orderFactory = $OrderFactory;
  }

  public function saveOrderItem(\App\Entity\OrderItemEntity $OrderItem): bool {
    // TODO: Implement saveOrderItem() method.
  }

  public function findByID(int $id): \App\Entity\OrderItemEntity {
    // TODO: Implement findByID() method.
  }

  public function findAllByOrderID(int $order_id): array {
    // TODO: Implement findAllByOrderID() method.
  }

}

