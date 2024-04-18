<?php

declare(strict_types=1);

namespace App\Component\Chat;

use App\Entity\Chat;
use App\Entity\User;
use DateTime;

class ChatFactory
{
    public function create(User $user, User $createdBy): Chat
    {
        return (new Chat())
            ->setUser($user)
            ->setCreatedBy($createdBy)
            ->setCreatedAt(new DateTime());
    }
}
