<?php

namespace App\Component\Chat;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class ChatDto
{
    public function __construct(
        #[Groups(['chat:write'])]
        private readonly User $user,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
