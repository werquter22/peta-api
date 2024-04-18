<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\UserFactory;
use App\Component\User\UserManager;
use App\Controller\Base\AbstractController;
use App\Entity\User;

/**
 * Class CreateUserController
 *
 * @package App\Controller
 */
class UserCreateAction extends AbstractController
{
    public function __invoke(User $data, UserFactory $userFactory, UserManager $userManager): User
    {
        $this->validate($data);

        $user = $userFactory->create($data->getUsername(), $data->getPassword(), $data->getPhone(), $data->getImage());
        $userManager->save($user, true);

        return $user;
    }
}
