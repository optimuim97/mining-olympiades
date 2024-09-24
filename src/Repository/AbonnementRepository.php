<?php

namespace App\Repository;

use App\Entity\Abonnement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Abonnement>
 *
 * @method Abonnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonnement[]    findAll()
 * @method Abonnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonnement::class);
    }

    public function getAbonnementWithCompagnie()
    {
        return $this->createQueryBuilder("a")
            ->addSelect('c')
            ->leftJoin('a.compagnie', 'c')
            ->orderBy('a.totalJoueur', 'DESC')
            ->getQuery()->getResult()
            ;
    }

    public function getTotalJoueur()
    {
        return $this->createQueryBuilder('a')
            ->select('SUM(a.totalJoueur) AS sum')
            ->getQuery()->getSingleScalarResult();
    }

    public function getRealAbonnement()
    {
        return $this->createQueryBuilder('a')
            ->where('a.totalJoueur <> a.restantJoueur')
            ->getQuery()->getResult();
    }
}
