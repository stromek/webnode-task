<?php
declare(strict_types=1);

namespace App\Controller\Order;



use App\Api\Response\ResponseFactory;
use App\Api\Response\ResponseInterface;
use App\Api\Response\Transformer\OrderResponseTransformer;
use App\Entity\OrderEntity;
use App\Repository\Order\OrderRepositoryInterface;
use App\Repository\OrderItem\OrderItemRepositoryInterface;


class OrderController extends \App\Controller\Controller {

  private readonly OrderRepositoryInterface $orderRepository;

  private readonly OrderItemRepositoryInterface $orderItemRepository;

  private readonly OrderResponseTransformer $orderResponseTransformer;


  public function __construct(OrderRepositoryInterface $Repository, OrderItemRepositoryInterface $OrderItemRepository, OrderResponseTransformer $OrderResponseTransformer) {
    $this->orderRepository = $Repository;
    $this->orderItemRepository = $OrderItemRepository;
    $this->orderResponseTransformer = $OrderResponseTransformer;
  }


  public function detail(int $id): ResponseInterface {
    if($id === 2) {
      throw new \RuntimeException("Example of RuntimeError");
    }

    $OrderEntity = $this->mergeOrderAndItems(
      $this->orderRepository->findByID($id),
      $this->orderItemRepository->findAllByOrderID($id)
    );

    return $this->responseFactory->create($this->orderResponseTransformer->transform($OrderEntity));
  }


  private function mergeOrderAndItems(OrderEntity $Order, array $orderItems): OrderEntity {
    foreach($orderItems as $OrderItem) {
      $Order->addItem($OrderItem);
    }

    return $Order;
  }

}