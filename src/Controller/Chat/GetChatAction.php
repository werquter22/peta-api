<?php

namespace App\Controller\Chat;

use ApiPlatform\Validator\ValidatorInterface;
use App\Component\Chat\ChatInfoDto;
use App\Component\Chat\ChatsInfoDto;
use App\Component\User\CurrentUser;
use App\Controller\Base\AbstractController;
use App\Entity\Chat;
use App\Entity\User;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

class GetChatAction extends AbstractController
{
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        CurrentUser $currentUser,
        private readonly HubInterface $hub
    ) {
        parent::__construct($serializer, $validator, $currentUser);
    }

    public function __invoke(int $id, ChatRepository $chatRepository, MessageRepository $messageRepository): ChatInfoDto
    {
        $chat = $chatRepository->find($id);
        $messages = $messageRepository->findAllByChat($id, $this->getUser());
        $filterMessages = [];
        $status = false;

        foreach ($messages as $message) {
            if ($message->getCreatedBy() !== $this->getUser() && !$message->getHasSeen()) {
                $status = true;
                $message->setHasSeen(true);
                $messageRepository->save($message, true);
            }

            $filterMessages[] = new ChatsInfoDto(
                $message->getId(),
                $message->getCreatedBy(),
                $message,
                0
            );
        }

        $this->watchNewMessages($status, $chat->getId());
        $this->watchAllChats($status);

        return new ChatInfoDto(
            $chat->getId(),
            $this->getUserByChat($chat),
            array_reverse($filterMessages)
        );
    }

    private function getUserByChat(Chat $chat): User
    {
        if ($chat->getUser() === $this->getUser()) {
            return $chat->getCreatedBy();
        }

        return $chat->getUser();
    }

    private function watchNewMessages(bool $status, int $chatId): void
    {
        $update = new Update(
            'chat/' . $chatId,
            json_encode(
                [
                    'status' => $status
                ],
            )
        );

        $this->hub->publish($update);
    }

    private function watchAllChats(bool $status): void
    {
        $update = new Update(
            'chats/',
            json_encode(
                [
                    'status' => $status
                ]
            )
        );

        $this->hub->publish($update);
    }
}
