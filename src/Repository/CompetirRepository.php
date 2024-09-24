<?php

namespace App\Repository;

use App\Entity\Competir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Competir>
 *
 * @method Competir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competir[]    findAll()
 * @method Competir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competir::class);
    }

    public function getParticipantByCompagnie($compagnie)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('p')
            ->addSelect('d')
            ->addSelect('cp')
            ->leftJoin('c.participant', 'p')
            ->leftJoin('c.discipline', 'd')
            ->leftJoin('p.compagnie', 'cp')
            ->where('cp = :compagnie')
            ->setParameter('compagnie', $compagnie)
            ->getQuery()->getResult()
            ;
    }
}
