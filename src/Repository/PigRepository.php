<?php

namespace App\Repository;

use App\Entity\Pig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pig|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pig|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pig[]    findAll()
 * @method Pig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PigRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pig::class);
    }

//    /**
//     * @return Pig[] Returns an array of Pig objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pig
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
