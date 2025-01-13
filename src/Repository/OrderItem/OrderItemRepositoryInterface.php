<?php
declare(strict_types=1);

namespace App\Repository\OrderItem;

use App\Entity\OrderItemEntity;


interface OrderItemRepositoryInterface extends \App\Repository\RepositoryInterface {

  public function findByID(int $id): OrderItemEntity;

  /**
   * @param int $order_id
   * @return OrderItemEntity[]
   */
  public function findAllByOrderID(int $order_id): array;


  public function saveOrderItem(OrderItemEntity $OrderItem): bool;

}