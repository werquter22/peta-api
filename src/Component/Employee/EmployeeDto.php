<?php

declare(strict_types=1);

namespace App\Component\Employee;

use App\Entity\Clinic;
use App\Entity\MediaObject;
use App\Entity\Service;
use Symfony\Component\Serializer\Annotation\Groups;

class EmployeeDto
{
    public function __construct(
        #[Groups(['employee:write'])]
        private ?string $userName,

        #[Groups(['employee:write'])]
        private ?string $password,

        #[Groups(['employee:write'])]
        private ?string $phone,

        #[Groups(['employee:write'])]
        private ?MediaObject $image,

        #[Groups(['employee:write'])]
        private ?Service $service,

        #[Groups(['employee:write'])]
        private ?int $price,

        #[Groups(['employee:write'])]
        private ?string $room,

        #[Groups(['employee:write'])]
        private ?Clinic $clinic
    ) {
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function getClinic(): ?Clinic
    {
        return $this->clinic;
    }
}
