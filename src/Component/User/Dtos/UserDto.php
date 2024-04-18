<?php

declare(strict_types=1);

namespace App\Component\User\Dtos;

use App\Entity\MediaObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserDto
{
    public function __construct(
        #[Groups(['user:write'])]
        private ?string $userName,

        #[Groups(['user:write'])]
        private ?string $password,

        #[Groups(['user:write'])]
        private ?string $phone,

        #[Groups(['user:write'])]
        private ?MediaObject $image
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
}
