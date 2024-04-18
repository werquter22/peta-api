<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Component\GetDates;
use App\Controller\Base\AbstractController;
use App\Repository\OrderRepository;
use DateTime;
use DateTimeZone;
use Symfony\Component\HttpFoundation\Request;

class GetTodayOrdersAction extends AbstractController
{
    public function __invoke(OrderRepository $orderRepository, Request $request, GetDates $getDates): array
    {
        $employee = $request->query->getInt('employee');
        $username = $request->query->get('username', '');

        $offset = (new DateTimeZone('Asia/Tashkent'))->getOffset(new DateTime('now'));
        $interval = $offset / 3600;
        $today = $getDates->getYesterdayDate()->setTime(23 - $interval, 59, 59);

        return $orderRepository->findTodayOrders($today, $employee, $username);
    }
}
