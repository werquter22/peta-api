<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Component\GetDates;
use App\Component\Order\OrderFactory;
use App\Controller\Base\AbstractController;
use App\Entity\Order;
use App\Repository\OrderRepository;
use DateTime;
use DateTimeZone;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CreateOrderAction extends AbstractController
{
    public function __invoke(Order $data, OrderFactory $orderFactory, OrderRepository $orderRepository, GetDates $getDates): Order
    {
        if ($data->getEmployee()->getUser() === $this->getUser()) {
            throw new AccessDeniedHttpException('You cannot order yourself');
        }

        $offset = (new DateTimeZone('Asia/Tashkent'))->getOffset(new DateTime('now'));
        $interval = $offset / 3600;

        $today = $getDates->getYesterdayDate()->setTime(23 - $interval, 59, 59);
        $countTodayOrders = $orderRepository->findCountTodayOrders($today, $data->getEmployee());

        return $orderFactory->create(
            $data->getEmployee(),
            $data->getEmployee()->getRoom() . $countTodayOrders + 1,
            $data->getIsHome()
        );
    }
}
