<?php

namespace App\Repository;

use App\Entity\House;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method House|null find($id, $lockMode = null, $lockVersion = null)
 * @method House|null findOneBy(array $criteria, array $orderBy = null)
 * @method House[]    findAll()
 * @method House[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, House::class);
    }

    public function findByUniqueIdNotNull() {

        $em = $this->getEntityManager();
        $RAW_QUERY = 'SELECT house_unique_id FROM house where house_unique_id IS NOT NULL;';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $statement->fetchAll();
    }

    function findByPig($pigId) {
      
    }

}
