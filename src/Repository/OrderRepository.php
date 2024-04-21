<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Order;
use App\Entity\Service;
use App\Entity\User;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Order[] Returns an array of Order objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findFilteredOrders(User $user, bool $isAdmin, bool $isDoctor, int $employee, int $service, int $createdBy, string $username): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o2');
        $basisQueryBuilder = $this->createQueryBuilder('o')
            ->leftJoin('o.employee', 'e')
            ->leftJoin('e.service', 's')
            ->leftJoin('o.createdBy', 'u')
            ->andWhere('o.deletedAt IS NULL');

        if ($isDoctor) {
            $basisQueryBuilder->andWhere('e.user = :user');
            $queryBuilder->setParameter('user', $user);
        } else if (!$isAdmin) {
            $basisQueryBuilder ->andWhere('o.createdBy = :user');
            $queryBuilder->setParameter('user', $user);
        }

        if ($employee > 0) {
            $basisQueryBuilder->andWhere('e.id = :employee');
            $queryBuilder->setParameter('employee', $employee);
        }

        if ($service > 0) {
            $basisQueryBuilder->andWhere('s.id = :service');
            $queryBuilder->setParameter('service', $service);
        }

        if ($createdBy > 0) {
            $basisQueryBuilder->andWhere('u.id = :createdBy');
            $queryBuilder->setParameter('createdBy', $createdBy);
        }

        if ($username !== '') {
            $basisQueryBuilder->andWhere('u.userName like :username');
            $queryBuilder->setParameter('username', '%' . $username . '%');
        }

        return $queryBuilder
            ->orderBy('o2.id', 'DESC')
            ->andWhere($queryBuilder->expr()->in('o2.id', $basisQueryBuilder->getDQL()));
    }

    public function ordersPagination(
        User $user,
        bool $isAdmin,
        bool $isDoctor,
        int $employee,
        int $service,
        int $createdBy,
        string $username,
        int $page,
        int $itemsPerPage
    ): array {
        return $this->findFilteredOrders($user, $isAdmin, $isDoctor, $employee, $service, $createdBy, $username)
            ->select('o2')
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage)
            ->getQuery()
            ->getResult();
    }

    public function ordersCount(
        User $user,
        bool $isAdmin,
        bool $isDoctor,
        int $employee,
        int $service,
        int $createdBy,
        string $username
    ): int {
        return (int)$this->findFilteredOrders($user, $isAdmin, $isDoctor, $employee, $service, $createdBy, $username)
            ->select('COUNT(o2.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Order[]
     */
    public function findTodayOrders(DateTimeInterface $today, int $employee, string $username): array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->leftJoin('o.employee', 'e')
            ->leftJoin('o.createdBy', 'u')
            ->andWhere('o.createdAt > :today')
            ->andWhere('o.deletedAt IS NULL');

        if ($employee > 0) {
            $queryBuilder
                ->andWhere('e.id = :employee')
                ->setParameter('employee', $employee);
        }

        if ($username !== '') {
            $queryBuilder
                ->andWhere('u.userName like :username')
                ->setParameter('username', '%' . $username . '%');
        }

        return $queryBuilder
            ->orderBy('o.createdAt', 'ASC')
            ->setParameter('today', $today)
            ->getQuery()
            ->getResult();

    }
}
