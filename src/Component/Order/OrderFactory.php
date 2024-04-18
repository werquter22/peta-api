<?php

declare(strict_types=1);

namespace App\Component\Order;

use App\Entity\Employee;
use App\Entity\Order;
use DateTime;

class OrderFactory
{
    public function create(Employee $employee, string $orderNumber, bool $isHome = false): Order
    {
        return (new Order())
            ->setEmployee($employee)
            ->setOrderNumber($orderNumber)
            ->setIsHome($isHome)
            ->setCreatedAt(new DateTime());
    }
}
