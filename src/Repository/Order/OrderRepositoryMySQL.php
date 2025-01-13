<?php
declare(strict_types=1);

namespace App\Repository\Order;

use App\Entity\OrderEntity;
use Dibi\Connection;
use App\Mapper\Order\OrderMapperMySQL;


class OrderRepositoryMySQL extends \App\Repository\RepositoryMySQL implements OrderRepositoryInterface {

  private OrderMapperMySQL $mapper;

  public function __construct(Connection $db, OrderMapperMySQL $Mapper) {
    parent::__construct($db);

    $this->mapper = $Mapper;
  }


  public function findByID(int $id): OrderEntity {
    $q = "
      SELECT *
      FROM order
      WHERE id = %i
    ";
    // $Row = $this->db->query($q, $id)->fetch();
    // Fake data
    $Row = $id >= 500 ? null : new \Dibi\Row($this->createFakeData($id));

    if(!$Row) {
      throw new OrderRepositoryException("Order ID #{$id} not found.", OrderRepositoryException::NOT_FOUND);
    }

    return $this->mapper->createOrderEntity($Row);
  }


  private function createFakeData(int $id): array {
    $Faker = \Faker\Factory::create("cs_CZ");
    $Faker->seed($id);

    $Date = $Faker->dateTime;
    $Date->setDate(2024, intval($Date->format("m")), intval($Date->format("d")));

    return [
      "id" => $id,
      "name" => $Faker->name,
      "emailAddress" => $Faker->email,
      "receivedDateTime" => $Date,
    ];
  }


  public function saveOrder(OrderEntity $Order): bool {
    // @TODO přesun do základního controlleru?
    $Order->mutate();
    $Order->validate();

    $data = $this->mapper->createMySQLDataFromOrderEntity($Order);

    $q = "
      INSERT INTO [order] %a ON DUPLICATE KEY UPDATE %a
    ";

    return $this->db->query($q, $data, $data)->getRowCount() > 0;
  }

}