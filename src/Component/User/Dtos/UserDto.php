<?php

declare(strict_types=1);

namespace App\Component\User\Dtos;

use App\Entity\Clinic;
use App\Entity\MediaObject;
use App\Entity\Service;
use Symfony\Component\Serializer\Annotation\Groups;

class UserDto
{
    public function __construct(
        #[Groups(['user:write'])]
        private ?string $email,

        #[Groups(['user:write'])]
        private ?string $password,

        #[Groups(['user:write'])]
        private ?string $givenName,

        #[Groups(['user:write'])]
        private ?string $familyName,

        #[Groups(['user:write'])]
        private ?string $phone,

        #[Groups(['user:write'])]
        private ?MediaObject $image
    ) {
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }
}
