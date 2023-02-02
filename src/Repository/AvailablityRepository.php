<?php

namespace App\Repository;

use App\Entity\Availablity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Availablity>
 *
 * @method Availablity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Availablity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Availablity[]    findAll()
 * @method Availablity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailablityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Availablity::class);
    }

    public function save(Availablity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Availablity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByDate(): array
    {
       return $this->createQueryBuilder('a')
           ->orderBy('a.startedAt', 'ASC')
           ->getQuery()
           ->getResult()
        ;
    }

//    /**
//     * @return Availablity[] Returns an array of Availablity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Availablity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
