<?php

namespace App\Repository;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function save(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Message[] Returns an array of Message objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Message
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @return Message[]
     */
    public function findAllByChat(int $chatId, User $createdBy): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.chat', 'ch')
            ->andWhere('ch.id = :chatId')
            ->andWhere('ch.user = :createdBy or ch.createdBy = :createdBy')
            ->andWhere('m.deletedAt IS NULL')
            ->orderBy('m.createdAt', 'DESC')
            ->setParameter('chatId', $chatId)
            ->setParameter('createdBy', $createdBy)
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    public function findLastMessage(Chat $chat): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.chat = :chat')
            ->andWhere('m.deletedAt IS NULL')
            ->orderBy('m.createdAt', 'DESC')
            ->setParameter('chat', $chat)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findUnseenCount(Chat $chat, User $user): int
    {
        return (int)$this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->andWhere('m.chat = :chat')
            ->andWhere('m.createdBy != :user')
            ->andWhere('m.hasSeen = false')
            ->andWhere('m.deletedAt IS NULL')
            ->setParameter('chat', $chat)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
