<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\MediaObject;
use App\Entity\User;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function create(string $userName, string $password, string $phone, ?MediaObject $image): User
    {
        $user = new User();
        $user->setUserName($userName);
        $user->setPhone($phone);
        $user->setImage($image);
        $user->setCreatedAt(new DateTime());
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));

        return $user;
    }
}
