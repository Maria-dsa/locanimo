<?php

namespace App\Repository;

use App\Entity\ScheduleRental;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ScheduleRental>
 *
 * @method ScheduleRental|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduleRental|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduleRental[]    findAll()
 * @method ScheduleRental[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRentalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScheduleRental::class);
    }

    public function save(ScheduleRental $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ScheduleRental $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ScheduleRental[] Returns an array of ScheduleRental objects
//     */
    public function findAllByOwner($user): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.animal', 'a')
            ->Where('a.owner = :user')
            ->setParameter('user', $user)
            ->orderBy('s.startedAt', 'ASC')
            ->setMaxResults(30)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByCustomer($user): array
    {
        return $this->createQueryBuilder('s')
            ->Where('s.customer = :user')
            ->setParameter('user', $user)
            ->orderBy('s.startedAt', 'ASC')
            ->setMaxResults(30)
            ->getQuery()
            ->getResult()
            ;
    }

//    public function findOneBySomeField($value): ?ScheduleRental
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
