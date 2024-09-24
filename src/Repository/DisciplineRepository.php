<?php

namespace App\Repository;

use App\Entity\Discipline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Discipline>
 *
 * @method Discipline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discipline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discipline[]    findAll()
 * @method Discipline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisciplineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discipline::class);
    }

    public function getListeExclues()
    {
        return $this->createQueryBuilder('d')
            ->where('d.Complementaire = :complementaire')
            ->setParameter('complementaire', true)
            ->orderBy('d.titre', 'ASC')
            ->getQuery()->getResult()
            ;
    }

    public function getListeWithAbonnement($discipline)
    {
        return $this->createQueryBuilder('d')
            ->addSelect('a')
            ->leftJoin('d.abonnements', 'a')
            ->where('d.id = :discipline')
            ->setParameter('discipline', $discipline)
            ->getQuery()->getResult();
    }
}
