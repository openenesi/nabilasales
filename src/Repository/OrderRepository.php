<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OrderRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Order::class);
    }

    public function findOneByDateCreated() {
        return $this->createQueryBuilder('c')
                        ->orderBy('c.dateCreated', 'DESC')
                        ->addOrderBy('c.id', 'DESC')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getResult();
    }


    public function findLastOrder($customerid = null) {
        if ($customerid == null) {
            return $this->createQueryBuilder('o')
                            ->orderBy('o.orderDate', 'DESC')
                            ->addOrderBy('o.id', 'DESC')
                            ->setMaxResults(1)
                            ->getQuery()
                            ->getResult();
        } else {
            return $this->createQueryBuilder('o')
                            ->where('o.customer=:cust')
                            ->orderBy('o.orderDate', 'DESC')
                            ->addOrderBy('o.id', 'DESC')
                            ->setParameter('cust', $customerid)
                            ->setMaxResults(1)
                            ->getQuery()
                            ->getResult();
        }
    }

    public function findLastStatusOrder($status, $customerid = null, $criteria = null) {
        if (isset($customerid)) {
            return $this->createQueryBuilder('o')
                            ->where('o.customer=:cust')
                            ->andWhere('o.orderStatus=:status')
                            ->orderBy('o.orderDate', 'DESC')
                            ->addOrderBy('o.id', 'DESC')
                            ->setParameter('cust', $customerid)
                            ->setParameter('status', $status)
                            ->setMaxResults(1)
                            ->getQuery()
                            ->getResult();
        } else {
            return $this->createQueryBuilder('o')
                            ->where('o.orderStatus=:status')
                            ->orderBy('o.orderDate', 'DESC')
                            ->addOrderBy('o.id', 'DESC')
                            ->setParameter('status', $status)
                            ->setMaxResults(1)
                            ->getQuery()
                            ->getResult();
        }
    }

    public function findAllStatusOrder($status, $customerid = null) {
        if (isset($customerid)) {
            return $this->createQueryBuilder('o')
                            ->where('o.customer=:cust')
                            ->andWhere('o.orderStatus=:status')
                            ->orderBy('o.orderDate', 'DESC')
                            ->addOrderBy('o.id', 'DESC')
                            ->setParameter('cust', $customerid)
                            ->setParameter('status', $status)
                            ->getQuery()
                            ->getResult();
        } else {
            return $this->createQueryBuilder('o')
                            ->where('o.orderStatus=:status')
                            ->orderBy('o.orderDate', 'DESC')
                            ->addOrderBy('o.id', 'DESC')
                            ->setParameter('status', $status)
                            ->getQuery()
                            ->getResult();
        }
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
