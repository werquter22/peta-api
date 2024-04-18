<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Controller\Base\AbstractController;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetOrdersAction extends AbstractController
{
    private const ITEMS_PER_PAGE = 10;

    public function __invoke(OrderRepository $orderRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $isAdmin = $this->hasRole('ROLE_ADMIN', $this->getUser());
        $isDoctor = $this->hasRole('ROLE_DOCTOR', $this->getUser());
        $employee = $request->query->getInt('employee');
        $service = $request->query->getInt('service');
        $createdBy = $request->query->getInt('createdBy');
        $username = $request->query->get('username', '');

        $orders = $orderRepository->ordersPagination(
            $this->getUser(),
            $isAdmin,
            $isDoctor,
            $employee,
            $service,
            $createdBy,
            $username,
            $page,
            self::ITEMS_PER_PAGE
        );

        $totalItems = $orderRepository->ordersCount(
            $this->getUser(),
            $isAdmin,
            $isDoctor,
            $employee,
            $service,
            $createdBy,
            $username
        );

        return $this->responseNormalized([
            'hydra:member' => $orders,
            'hydra:totalItems' => $totalItems,
            'hydra:itemsPerPage' => self::ITEMS_PER_PAGE
        ]);
    }
}
