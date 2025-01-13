<?php
declare(strict_types=1);

namespace App\Repository\Order;

interface OrderRepositoryInterface extends \App\Repository\RepositoryInterface {

  public function findByID(int $id): \App\Entity\OrderEntity;

  public function saveOrder(\App\Entity\OrderEntity $Order): bool;
}