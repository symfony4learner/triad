<?php

namespace App\Repository;

use App\Entity\Triad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Triad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Triad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Triad[]    findAll()
 * @method Triad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TriadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Triad::class);
    }

//    /**
//     * @return Triad[] Returns an array of Triad objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Triad
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
