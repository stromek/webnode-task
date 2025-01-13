<?php
declare(strict_types=1);

use App\Repository\Order\OrderRepositoryInterface;
use App\Repository\Order\OrderRepositoryMySQL;
use App\Repository\OrderItem\OrderItemRepositoryInterface;
use App\Repository\OrderItem\OrderItemRepositoryMySQL;

return [
  OrderRepositoryInterface::class => DI\autowire(OrderRepositoryMySQL::class),
  OrderItemRepositoryInterface::class => DI\autowire(OrderItemRepositoryMySQL::class),
];