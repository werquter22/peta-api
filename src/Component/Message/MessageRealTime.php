<?php

declare(strict_types=1);

namespace App\Component\Message;


use App\Entity\Message;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class MessageRealTime
{
    public function __construct(
        private readonly HubInterface $hub
    ) {
    }

    public function watchMessages(Message $message): void
    {
        $update = new Update(
            'chat/' . $message->getChat()->getId(),
            json_encode(
                [
                    'status' => true
                ]
            )
        );

        $this->hub->publish($update);
    }

    public function watchAllChats(): void
    {
        $update = new Update(
            'chats',
            json_encode(
                [
                    'status' => true
                ]
            )
        );

        $this->hub->publish($update);
    }
}
