<?php

declare(strict_types=1);

namespace App\Component\Message;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use DateTime;

class MessageFactory
{
    public function create(Chat $chat, string $text, User $createdBy, int $orderStatus = 0): Message
    {
        return (new Message())
            ->setChat($chat)
            ->setText($text)
            ->setOrderStatus($orderStatus)
            ->setCreatedBy($createdBy)
            ->setCreatedAt(new DateTime());
    }
}
