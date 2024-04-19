<?php

namespace App\Component\Chat;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class ChatInfoDto
{
    public function __construct(
        #[Groups(['chat:read', 'message:read'])]
        private int $id,

        #[Groups(['chat:read', 'message:read'])]
        private User $user,

        #[Groups(['chat:read', 'message:read'])]
        private array $messages
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}
