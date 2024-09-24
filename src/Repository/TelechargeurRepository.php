<?php

namespace App\Repository;

use App\Entity\Telechargeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Telechargeur>
 *
 * @method Telechargeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telechargeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telechargeur[]    findAll()
 * @method Telechargeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelechargeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telechargeur::class);
    }

//    /**
//     * @return Telechargeur[] Returns an array of Telechargeur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Telechargeur
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
