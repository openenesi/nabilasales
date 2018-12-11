<?php

namespace App\Repository;

use App\Entity\{
    Transaction,
    Order
};
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TransactionRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Transaction::class);
    }

    public function getAmtPaidBefore(Transaction $transaction, Order $order) {
        return $this->createQueryBuilder('t')->select('sum(t.amountPaid) as sumamt')
                        ->where('t.transDate < :dt')
                        ->andWhere('t.order= :order')
                        ->setParameter('dt', $transaction->getTransDate()->format('Y-m-d H:i:s'))
                        ->setParameter('order', $order->getId())
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getResult();
    }

    public function getAmtPaidAfter(Transaction $transaction, Order $order) {
        return $this->createQueryBuilder('t')->select('sum(t.amountPaid) as sumamt')
                        ->where('t.transDate <= :dt')
                        ->andWhere('t.order= :order')
                        ->setParameter('dt', $transaction->getTransDate()->format('Y-m-d H:i:s'))
                        ->setParameter('order', $order->getId())
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getResult();
    }

    public function findOneByDateCreated() {
        return $this->createQueryBuilder('t')
                        ->orderBy('t.dateCreated', 'DESC')
                        ->addOrderBy('t.id', 'DESC')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getResult();
    }

    public function findLastTransaction($entity = null, $on = 'customer') {

        $qbuilder = $this->createQueryBuilder('t')
                ->innerJoin(\App\Entity\Order::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, '(t.order = o)')
                ->innerJoin(\App\Entity\Customer::class, 'c', \Doctrine\ORM\Query\Expr\Join::WITH, '(o.customer= c)')
                ->orderBy('t.dateCreated', 'DESC')
                ->addOrderBy('t.id', 'DESC')
                ->setMaxResults(1);

        if (isset($entity)) {
            if ($on == 'order')
                $qbuilder = $qbuilder->where('o.id = :order')->setParameter('order', $entity->getId());
            else
                $qbuilder = $qbuilder->where('c.id = :customer')->setParameter('customer', $entity->getId());
        }
//echo $qbuilder->getQuery()->getSQL(); exit;
        return $qbuilder->getQuery()->getResult();
    }

    /*
      public function findBySomething($value)
      {
      return $this->createQueryBuilder('t')
      ->where('t.something = :value')->setParameter('value', $value)
      ->orderBy('t.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */
}
