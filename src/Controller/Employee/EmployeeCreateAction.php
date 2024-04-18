<?php

declare(strict_types=1);

namespace App\Controller\Employee;

use App\Component\Employee\EmployeeFactory;
use App\Component\Employee\EmployeeDto;
use App\Component\User\UserFactory;
use App\Component\User\UserManager;
use App\Controller\Base\AbstractController;
use App\Entity\Employee;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateUserController
 *
 * @package App\Controller
 */
class EmployeeCreateAction extends AbstractController
{
    public function __invoke(
        Request $request,
        UserFactory $userFactory,
        UserManager $userManager,
        EmployeeFactory $employeeFactory
    ): Employee {
        /**
         * @var EmployeeDto $employeeDto
         */
        $employeeDto = $this->getDtoFromRequest($request, EmployeeDto::class);

        $user = $userFactory->create(
            $employeeDto->getUserName(),
            $employeeDto->getPassword(),
            $employeeDto->getPhone(),
            $employeeDto->getImage()
        );

        $user->addRole('ROLE_DOCTOR');
        $userManager->save($user);

        return $employeeFactory->create(
            $user,
            $employeeDto->getService(),
            $employeeDto->getPrice(),
            $employeeDto->getRoom(),
            $employeeDto->getClinic(),
            $this->getUser());
    }
}
