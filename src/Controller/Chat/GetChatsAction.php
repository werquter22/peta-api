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
        $userName = $request->query->get('userName', '');
        $chats = $chatRepository->findAllByUser($this->getUser(), $userName);
        $filterChats = [];

        foreach ($chats as $chat) {
            $unSeenNumber = $messageRepository->findUnseenCount($chat, $this->getUser());
            $lastMessage = $messageRepository->findLastMessage($chat);

            $filterChats[] = new ChatsInfoDto(
                $chat->getId(),
                $this->getUserByChat($chat),
                $lastMessage,
                $unSeenNumber
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
