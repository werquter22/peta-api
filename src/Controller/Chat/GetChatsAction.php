<?php

namespace App\Controller\Chat;

use App\Component\Chat\ChatsInfoDto;
use App\Controller\Base\AbstractController;
use App\Entity\Chat;
use App\Entity\User;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;

class GetChatsAction extends AbstractController
{
    public function __invoke(
        ChatRepository $chatRepository,
        MessageRepository $messageRepository,
        Request $request
    ): array {
        $chats = $chatRepository->findAllByUser($this->getUser());
        $filterChats = [];

        foreach ($chats as $chat) {
            $lastMessage = $messageRepository->findLastMessage($chat);

            $filterChats[] = new ChatsInfoDto(
                $chat->getId(),
                $this->getUserByChat($chat)->getGivenName(),
                $this->getUserByChat($chat)->getFamilyName(),
                $this->getUserByChat($chat)->getImage(),
                $lastMessage,
                $lastMessage?->getCreatedAt(),
            );
        }

        return $filterChats;
    }

    private function getUserByChat(Chat $chat): User
    {
        if ($chat->getUser() === $this->getUser()) {
            return $chat->getCreatedBy();
        }

        return $chat->getUser();
    }
}
