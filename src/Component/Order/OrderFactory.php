<?php

declare(strict_types=1);

namespace App\Component\Order;

use App\Entity\Employee;
use App\Entity\Order;
use DateTimeInterface;

class OrderFactory
{
    public function create(Employee $employee, DateTimeInterface $createdAt, bool $isHome = false): Order
    {
        return (new Order())
            ->setEmployee($employee)
            ->setIsHome($isHome)
            ->setCreatedAt($createdAt);
    }
}
