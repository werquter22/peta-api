<?php

declare(strict_types=1);

namespace App\Controller\Message;

use App\Component\Message\MessageFactory;
use App\Component\Message\MessageRealTime;
use App\Controller\Base\AbstractController;
use App\Entity\Message;
use App\Repository\MessageRepository;

class CreateMessageAction extends AbstractController
{
    public function __invoke(
        Message $data,
        MessageRepository $messageRepository,
        MessageFactory $messageFactory,
        MessageRealTime $messageRealTime
    ): Message {
        $message = $messageFactory->create($data->getChat(), $data->getText(), $this->getUser());
        $messageRepository->save($message, true);
        $messageRealTime->watchMessages($message->getChat());
        $messageRealTime->watchAllChats();

        return $message;
    }
}
