<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\Dtos\UserDto;
use App\Controller\Base\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class CreateUserController
 *
 * @package App\Controller
 */
class UserPutAction extends AbstractController
{
    public function __invoke(int $id, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder): User
    {
        /**
         * @var UserDto $userDto
         */
        $userDto = $this->getDtoFromRequest($request, UserDto::class);
        $user = $userRepository->find($id);

        if ($userDto->getEmail() !== null) {
            $user->setEmail($userDto->getEmail());
        }

        if ($userDto->getPassword() !== null) {
            $user->setPassword($passwordEncoder->hashPassword($user, $userDto->getPassword()));
        }

        if ($userDto->getGivenName() !== null) {
            $user->setGivenName($userDto->getGivenName());
        }

        if ($userDto->getFamilyName() !== null) {
            $user->setFamilyName($userDto->getFamilyName());
        }

        if ($userDto->getPhone() !== null) {
            $user->setPhone($userDto->getPhone());
        }

        if ($userDto->getImage() !== null) {
            $user->setImage($userDto->getImage());
        }

        return $user;
    }
}
