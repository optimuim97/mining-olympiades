<?php

namespace App\Repository;

use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Joueur>
 *
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }

    public function getJoueurByCompagnie($compagnie)
    {
        return $this->createQueryBuilder('j')
            ->addSelect('a')
            ->addSelect('d')
            ->addSelect('c')
            ->leftJoin('j.abonnement', 'a')
            ->leftJoin('j.discipline', 'd')
            ->leftJoin('a.compagnie', 'c')
            ->where('a.compagnie = :compagnie')
            ->setParameter('compagnie', $compagnie)
            ->getQuery()->getResult()
            ;
    }

    public function getNombreJoueurByAbonnementAndDiscipline(int $discipline, int $abonnement)
    {
        return $this->createQueryBuilder('j')
            ->addSelect('a')
            ->addSelect('d')
            ->leftJoin('j.abonnement', 'a')
            ->leftJoin('j.discipline', 'd')
            ->where('a.id = :abonnement')
            ->andWhere('d.id = :discipline')
            ->setParameters([
                'discipline' => $discipline,
                'abonnement' => $abonnement
            ])
            ->getQuery()->getResult();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('j')
            ->addSelect('a')
            ->addSelect('d')
            ->leftJoin('j.abonnement', 'a')
            ->leftJoin('j.discipline', 'd')
            ->getQuery()->getResult()
            ;
    }

    public function getOneById($joueur)
    {
        return $this->createQueryBuilder('j')
            ->addSelect('a')
            ->addSelect('d')
            ->leftJoin('j.abonnement', 'a')
            ->leftJoin('j.discipline', 'd')
            ->where('j.id = :joueur')
            ->setParameter('joueur', $joueur)
            ->getQuery()->getOneOrNullResult()
            ;
    }

    public function getJoueursByAbonnement($abonnement)
    {
        return $this->createQueryBuilder('j')
            ->addSelect('a')
            ->addSelect('d')
            ->leftJoin('j.abonnement', 'a')
            ->leftJoin('j.discipline', 'd')
            ->where('a.id = :abonnement')
            ->setParameter('abonnement', $abonnement)
            ->getQuery()->getResult()
            ;
    }

    public function getJoueursByDisciplineGroupByAbonnement($discipline)
    {
        return $this->createQueryBuilder('j')
            ->addSelect('d')
            ->leftJoin('j.discipline', 'd')
            ->where('d.id = :discipline')
            ->groupBy('j.abonnement')
            ->setParameter('discipline', $discipline)
            ->getQuery()->getResult();
    }

    public function getJoueursByDisciplineGroupByCompagnie($discipline)
    {
        return $this->createQueryBuilder('j')
            ->addSelect('d')
            ->addSelect('a')
            ->leftJoin('j.discipline', 'd')
            ->leftJoin('j.abonnement', 'a')
            ->where('d.id = :discipline')
            ->groupBy('a.compagnie')
            ->setParameter('discipline', $discipline)
            ->getQuery()->getResult();
    }

}
