<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, User::class);
    }

    public function hasRecord($user) {

        $loading = $this->createQueryBuilder('t')
                ->innerJoin(\App\Entity\Loading::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, '(o.createdBy = t OR o.receivedBy = t)')
                ->where('o.createdBy = :usr')->setParameter('usr', $user)
                ->orWhere('o.receivedBy = :usr')->setParameter('usr', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();

        $order = $this->createQueryBuilder('t')
                ->innerJoin(\App\Entity\Order::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, '(o.cancelledBy = t OR o.staff= t)')
                ->where('o.cancelledBy = :usr')->setParameter('usr', $user)
                ->orWhere('o.staff = :usr')->setParameter('usr', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();
        $transaction = $this->createQueryBuilder('t')
                ->innerJoin(\App\Entity\Transaction::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, '(o.receivedBy = t OR o.cancelledBy = t OR o.refundedBy = t OR o.divertedBy = t)')
                ->where('o.receivedBy = :usr')->setParameter('usr', $user)
                ->orWhere('o.cancelledBy = :usr')->setParameter('usr', $user)
                ->orWhere('o.refundedBy = :usr')->setParameter('usr', $user)
                ->orWhere('o.divertedBy = :usr')->setParameter('usr', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();
        $orderItem = $this->createQueryBuilder('t')
                ->innerJoin(\App\Entity\OrderItem::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, '(o.deliveryEnteredBy = t OR o.cancelledBy = t)')
                ->where('o.deliveryEnteredBy = :usr')->setParameter('usr', $user)
                ->orWhere('o.cancelledBy = :usr')->setParameter('usr', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();
        //echo $loading[0]->getUsername();
        //exit();
        if (count($transaction) || count($order) || count($loading) || count($orderItem)) {
            return true;
        }
        return false;
    }

    /*
      public function findBySomething($value)
      {
      return $this->createQueryBuilder('u')
      ->where('u.something = :value')->setParameter('value', $value)
      ->orderBy('u.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */
}
