<?php

namespace App\Component\Chat;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class ChatsInfoDto
{
    public function __construct(
        #[Groups(['chat:read', 'message:read'])]
        private int $id,

        #[Groups(['chat:read', 'message:read'])]
        private User $user,

        #[Groups(['chat:read', 'message:read'])]
        private ?Message $message,

        #[Groups(['chat:read'])]
        private int $unSeenNumber
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

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function getUnSeenNumber(): int
    {
        return $this->unSeenNumber;
    }
}
