<?php

namespace App\Repository;

use App\Entity\Chat;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chat>
 *
 * @method Chat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chat[]    findAll()
 * @method Chat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    public function save(Chat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Chat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Chat[] Returns an array of Chat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Chat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findOneByUser(User $user, User $createdBy): ?Chat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :user AND c.createdBy = :createdBy')
            ->orWhere('c.createdBy = :user AND c.user = :createdBy')
            ->andWhere('c.deletedAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('createdBy', $createdBy)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Chat[]
     */
    public function findAllByUser(User $createdBy, string $userName): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->leftJoin('c.messages', 'm')
            ->leftJoin('c.user', 'u')
            ->leftJoin('c.createdBy', 'cb')
            ->andWhere('c.deletedAt IS NULL')
            ->andWhere('c.user = :createdBy OR c.createdBy = :createdBy');

        if ($userName !== '') {
            $queryBuilder
                ->andWhere('u.userName like :userName OR cb.userName like :userName')
                ->setParameter('userName', '%' . $userName . '%');
        }

        return $queryBuilder
            ->orderBy('m.createdAt', 'DESC')
            ->setParameter('createdBy', $createdBy)
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }
}
