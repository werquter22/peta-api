<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Component\Chat\ChatFactory;
use App\Component\Message\MessageFactory;
use App\Component\Message\MessageRealTime;
use App\Controller\Base\AbstractController;
use App\Entity\Order;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;

class AdmissionAction extends AbstractController
{
    public function __invoke(
        Order $data,
        ChatRepository $chatRepository,
        ChatFactory $chatFactory,
        MessageRepository $messageRepository,
        MessageFactory $messageFactory,
        MessageRealTime $messageRealTime,
    ): Order {
        $data->setStatus($data->getStatus());

        $chat = $chatRepository->findOneByUser($data->getCreatedBy(), $this->getUser());

        if ($chat === null) {
            $chat = $chatFactory->create($data->getCreatedBy(), $this->getUser());
            $chatRepository->save($chat);
        }

        $message = $messageFactory->create($chat, 'id ' . $data->getId(), $this->getUser(), $data->getStatus());
        $messageRepository->save($message, true);
        $messageRealTime->watchMessages($chat);
        $messageRealTime->watchAllChats();

        return $data;
    }
}
