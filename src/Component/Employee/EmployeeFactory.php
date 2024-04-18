<?php

declare(strict_types=1);

namespace App\Component\Employee;

use App\Entity\Clinic;
use App\Entity\Employee;
use App\Entity\Service;
use App\Entity\User;
use DateTime;

class EmployeeFactory
{
    public function create(
        User $user,
        Service $service,
        int $price,
        string $room,
        Clinic $clinic,
        User $createdBy
    ): Employee {
        return (new Employee())
            ->setUser($user)
            ->setService($service)
            ->setPrice($price)
            ->setRoom($room)
            ->setClinic($clinic)
            ->setCreatedBy($createdBy)
            ->setCreatedAt(new DateTime());
    }
}
