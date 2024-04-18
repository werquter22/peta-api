<?php

declare(strict_types=1);

namespace App\Controller\Message;

use App\Component\Chat\ChatsInfoDto;
use App\Controller\Base\AbstractController;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;

class GetMessagesAction extends AbstractController
{
    public function __invoke(Request $request, MessageRepository $messageRepository): array
    {
        $chatId = $request->query->getInt('chat');

        $messages = $messageRepository->findAllByChat($chatId, $this->getUser());
        $filterMessages = [];

        foreach ($messages as $message) {
            $filterMessages[] = new ChatsInfoDto(
                $message->getId(),
                $message->getCreatedBy()->getUsername(),
                $message,
                $message->getCreatedAt(),
            );
        }

        return $filterMessages;
    }
}
