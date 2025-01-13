<?php
declare(strict_types=1);

namespace App\Repository\OrderItem;

use App\Entity\OrderItemEntity;
use App\Mapper\OrderItem\OrderItemMapperMySQL;


class OrderItemRepositoryMySQL extends \App\Repository\RepositoryMySQL implements OrderItemRepositoryInterface {

  private OrderItemMapperMySQL $mapper;

  public function __construct(\Dibi\Connection $db, OrderItemMapperMySQL $Mapper) {
    parent::__construct($db);

    $this->mapper = $Mapper;
  }

  public function findByID(int $id): OrderItemEntity {
    $q = "
      SELECT *
      FROM orderItem
      WHERE id = %i
    ";

//    $Row = $this->db->query($q, $id)->fetch();
    $Row = new \Dibi\Row([
      "id" => $id,
    ]);

    if(!$Row) {
      throw new OrderItemRepositoryException("OrderItem ID #{$id} not found.", OrderItemRepositoryException::NOT_FOUND);
    }

    return $this->mapper->createOrderItemEntity($Row);
  }


  public function findAllByOrderID(int $order_id): array {
    $q = "
      SELECT *
      FROM orderItem
      WHERE order_id = %i
    ";
//    $Rows = $this->db->query($q, $order_id)->fetchAll();
    $Rows = [];

    for($i = 0, $l = rand(5, 10); $i < $l; $i++) {
      $Rows[] = new \Dibi\Row($this->createFakeData($order_id, $i));
    }

    return array_map(fn(\Dibi\Row $Row): OrderItemEntity => $this->mapper->createOrderItemEntity($Row), $Rows);
  }


  private function createFakeData(int $order_id, int $i): array {
    $Faker = \Faker\Factory::create("cs_CZ");
    $Faker->seed($order_id + $i);

    $vatRate = 21;
    $priceBase = $Faker->randomNumber(4);
    $priceTotal = $priceBase * ($vatRate / 100 + 1);

    return [
      "id" => $Faker->randomNumber(5, true),
      "order_id" => $order_id,
      "name" => $Faker->words(rand(1, 3), true),
      "priceBase" => $priceBase,
      "priceVat" => $priceTotal - $priceBase,
      "priceTotal" => $priceTotal,
      "vatRate" => $vatRate,
    ];
  }

  public function saveOrderItem(OrderItemEntity $OrderItem): bool {
    // TODO: Implement saveOrderItem() method.
  }

}