<?php

namespace App\Repository;

use App\Entity\Loading;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LoadingRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Loading::class);
    }

    public function findOneByDateCreated() {
        return $this->createQueryBuilder('c')
                        ->orderBy('c.dateCreated', 'DESC')
                        ->addOrderBy('c.id', 'DESC')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getResult();
    }

    /*
      public function findBySomething($value)
      {
      return $this->createQueryBuilder('o')
      ->where('o.something = :value')->setParameter('value', $value)
      ->orderBy('o.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */
}
