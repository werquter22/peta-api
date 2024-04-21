<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Component\GetDates;
use App\Component\Order\OrderFactory;
use App\Controller\Base\AbstractController;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CreateOrderAction extends AbstractController
{
    public function __invoke(Order $data, OrderFactory $orderFactory, OrderRepository $orderRepository, GetDates $getDates): Order
    {
        if ($data->getEmployee()->getUser() === $this->getUser()) {
            throw new AccessDeniedHttpException('You cannot order yourself');
        }

        return $orderFactory->create(
            $data->getEmployee(),
            $data->getCreatedAt()->modify('-5 hours'),
            $data->getIsHome()
        );
    }
}
