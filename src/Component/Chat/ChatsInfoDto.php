<?php

namespace App\Component\Chat;

use App\Entity\MediaObject;
use App\Entity\Message;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ChatsInfoDto
{
    public function __construct(
        #[Groups(['chat:read', 'message:read'])]
        private int $id,

        #[Groups(['chat:read', 'message:read'])]
        private string $userName,

        #[Groups(['chat:read', 'message:read'])]
        private ?Message $message,

        #[Groups(['chat:read', 'message:read'])]
        private ?DateTimeInterface $createdAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }
}
