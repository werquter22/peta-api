<?php

declare(strict_types=1);

namespace App\Component\Service;

use App\Entity\Service;
use App\Entity\User;
use DateTime;

class ServiceFactory
{
    public function create(string $name, User $user): Service
    {
        return (new Service())
            ->setName($name)
            ->setCreatedBy($user)
            ->setCreatedAt(new DateTime());
    }
}
