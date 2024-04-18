<?php

declare(strict_types=1);

namespace App\Controller\Chat;

use App\Component\Chat\ChatDto;
use App\Component\Chat\ChatFactory;
use App\Controller\Base\AbstractController;
use App\Entity\Chat;
use App\Repository\ChatRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CreateChatAction extends AbstractController
{
    public function __invoke(Request $request, SerializerInterface $serializer, ChatRepository $chatRepository, ChatFactory $chatFactory): Chat
    {
        /**
         * @var ChatDto $chatDto
         */
        $chatDto = $serializer->deserialize($request->getContent(), ChatDto::class, 'json');

        if ($chatDto->getUser() === $this->getUser()) {
            throw new BadRequestException('You cannot send message to your user');
        }

        $chat = $chatRepository->findOneByUser($chatDto->getUser(), $this->getUser());

        if ($chat === null) {
            $chat = $chatFactory->create($chatDto->getUser(), $this->getUser());
        }

        return $chat;
    }
}
