<?php

declare(strict_types=1);

namespace App\Controller\Employee;

use App\Controller\Base\AbstractController;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetEmployeesAction extends AbstractController
{
    private const ITEMS_PER_PAGE = 12;

    public function __invoke(EmployeeRepository $employeeRepository,  Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $userName = $request->query->get('userName', '');
        $service = $request->query->getInt('service');
        $clinic = $request->query->getInt('clinic');

        $employees = $employeeRepository->employeesPagination($userName, $service, $clinic, $page, self::ITEMS_PER_PAGE);
        $totalItems = $employeeRepository->employeesCount($userName, $service, $clinic);

        return $this->responseNormalized([
            'hydra:member' => $employees,
            'hydra:totalItems' => $totalItems,
            'hydra:itemsPerPage' => self::ITEMS_PER_PAGE
        ]);
    }
}