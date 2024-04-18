<?php

declare(strict_types=1);

namespace App\Controller\Employee;

use App\Component\Employee\EmployeeDto;
use App\Controller\Base\AbstractController;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class CreateUserController
 *
 * @package App\Controller
 */
class EmployeePutAction extends AbstractController
{
    public function __invoke(int $id, Request $request, EmployeeRepository $employeeRepository, UserPasswordHasherInterface $passwordEncoder): Employee
    {
        /**
         * @var EmployeeDto $employeeDto
         */
        $employeeDto = $this->getDtoFromRequest($request, EmployeeDto::class);
        $employee = $employeeRepository->find($id);

        if ($employeeDto->getUserName() !== null) {
            $employee->getUser()->setUserName($employeeDto->getUserName());
        }

        if ($employeeDto->getPassword() !== null) {
            $employee->getUser()->setPassword($passwordEncoder->hashPassword($employee->getUser(), $employeeDto->getPassword()));
        }

        if ($employeeDto->getPhone() !== null) {
            $employee->getUser()->setPhone($employeeDto->getPhone());
        }

        if ($employeeDto->getImage() !== null) {
            $employee->getUser()->setImage($employeeDto->getImage());
        }

        if ($employeeDto->getService() !== null) {
            $employee->setService($employeeDto->getService());
        }

        if ($employeeDto->getPrice() !== null) {
            $employee->setPrice($employeeDto->getPrice());
        }

        if ($employeeDto->getClinic() !== null) {
            $employee->setClinic($employeeDto->getClinic());
        }

        return $employee;
    }
}
