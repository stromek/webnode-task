<?php
declare(strict_types=1);

namespace App\Repository\Order;

use Elastic\Elasticsearch\Client;
use App\Mapper\Order\OrderMapperElastic;
use App\Repository\RepositoryException;


class OrderRepositoryElastic extends \App\Repository\RepositoryElastic implements OrderRepositoryInterface {

  private OrderMapperElastic $mapper;

  public function __construct(Client $client, OrderMapperElastic $Mapper) {
    parent::__construct($client);

    $this->mapper = $Mapper;
  }

  public function findByID(int $id): \App\Entity\OrderEntity {
    $params = [
      'index' => 'orders',
      'id'    => $id
    ];

    $response = $this->client->get($params);

    if(!$response['found']) {
      throw new OrderRepositoryException("Order ID #{$id} not found.", RepositoryException::NOT_FOUND);
    }

    return $this->mapper->createOrderEntity($response);
  }


  public function saveOrder(\App\Entity\OrderEntity $Order): bool {
    throw new \App\Exception\NotImplementedException();
  }
}