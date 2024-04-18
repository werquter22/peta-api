<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function save(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findFilteredEmployees(string $userName, int $service, int $clinic): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('e2');
        $basisQueryBuilder = $this->createQueryBuilder('e')
            ->leftJoin('e.user', 'u')
            ->leftJoin('e.service', 's')
            ->leftJoin('e.clinic', 'c')
            ->andWhere('e.deletedAt IS NULL');

        if ($userName !== '') {
            $basisQueryBuilder->andWhere('u.userName like :userName');
            $queryBuilder->setParameter('userName', '%' . $userName . '%');
        }

        if ($service > 0) {
            $basisQueryBuilder->andWhere('s.id = :service');
            $queryBuilder->setParameter('service', $service);
        }

        if ($clinic > 0) {
            $basisQueryBuilder->andWhere('c.id = :clinic');
            $queryBuilder->setParameter('clinic', $clinic);
        }

        return $queryBuilder
            ->andWhere($queryBuilder->expr()->in('e2.id', $basisQueryBuilder->getDQL()));
    }

    public function employeesPagination(string $userName, int $service, int $clinic, int $page, int $itemsPerPage): array
    {
        return $this->findFilteredEmployees($userName, $service, $clinic)
            ->select('e2')
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage)
            ->getQuery()
            ->getResult();
    }

    public function employeesCount(string $userName, int $service, int $clinic): int
    {
        return (int)$this->findFilteredEmployees($userName, $service, $clinic)
            ->select('COUNT(e2.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
