<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @UniqueEntity(fields="oRef", message="Order Ref must be unique")
 * @ORM\Table(name="productorder")
 */
class Order {

    use \App\Utility\Utils;

    public function __construct() {
        $this->orderItems = new ArrayCollection();
        $dt = new \DateTime();
        $this->orderDate = $dt;
        $this->dateCreated = $dt;
        $this->orderStatus = "pending";
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name= "order_id", type="integer")
     */
    private $id;
    // add your own fields

    /**
     *
     * @ORM\Column(type="integer", nullable=false, unique=true, options={"unsigned":true})
     */
    private $oRef;

    /**
     * @Assert\NotBlank(message="Invalid date of order")
     * @Assert\DateTime(message = "Order Date must be a valid date with time.")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $orderDate;

    /**
     * @Assert\NotBlank(message="Date of entry unknown!")
     * @Assert\DateTime(message = "Date recorded must be a valid date with time.")
     * @Assert\GreaterThanOrEqual(propertyPath="orderDate", message="Date Created must be a date on or after the actual order date.")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @Assert\NotBlank(message="Select who initiate the order (Staff or Customer)")
     * @Assert\Choice(choices= {"customer","staff"}, message="Invalid Option")
     * @ORM\Column(type="string", nullable=false, length=20)
     */
    private $initiatedBy;

    /**
     * 
     * @Assert\NotBlank(message="Select a customer/client/agent")
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="customer_id", nullable=false)
     */
    private $customer;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="order_placed_by", referencedColumnName="user_id", nullable=true)
     */
    private $staff;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback= "getUtilOrderStatus", message="Invalid Order Status")
     * @ORM\Column(type="string", nullable=false, length=20, options={"default":"pending"})
     */
    private $orderStatus;

    /**
     *
     * @Assert\GreaterThanOrEqual(propertyPath="orderDate", message="Date of cancellation must be on or after order date.")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCancelled;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $cancellationRemark;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="user_id", nullable=true)
     */
    private $cancelledBy;

    /**
     * @Assert\Choice(choices= {"customer","staff"}, message="Invalid Option")
     * @ORM\Column(type="string", length=20, name="cancellation_initiated_by", nullable=true)
     */
    private $cancellationInitiatedBy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="order")
     */
    private $orderItems;

    public function getId() {
        return $this->id;
    }

    public function getORef() {
        return $this->oRef;
    }

    public function setORef($oref) {
        $this->oRef = $oref;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($created) {
        $this->dateCreated = $created;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function setOrderDate($odate) {
        $this->orderDate = $odate;
    }

    public function getInitiatedBy() {
        return $this->cancelledBy;
    }

    public function setInitiatedBy($initby) {
        if (!in_array($initby, array('staff', 'customer'))) {
            throw new \InvalidArgumentException("Invalid option for field 'InitiatedBy'");
        }
        $this->initiatedBy = $initby;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function setCustomer($customer) {
        $this->customer = $customer;
    }

    public function getStaff() {
        return $this->staff;
    }

    public function setStaff($staff) {
        $this->staff = $staff;
    }

    public function getOrderStatus() {
        return $this->orderStatus;
    }

    public function setOrderStatus($ostatus) {
        if (!in_array($ostatus, Order::getUtilOrderStatus())) {
            throw new \InvalidArgumentException("Invalid Order Status");
        }
        $this->orderStatus = $ostatus;
    }

    public function getDateCancelled() {
        return $this->dateCancelled;
    }

    public function setDateCancelled($dtcancelled) {
        $this->dateCancelled = $dtcancelled;
    }

    public function getCancellationRemark() {
        return $this->cancellationRemark;
    }

    public function setCancellationRemark($cremark) {
        $this->cancellationRemark = $cremark;
    }

    public function getCancelledBy() {
        return $this->cancelledBy;
    }

    public function setCancelledBy($cancelledby) {
        $this->cancelledBy = $cancelledby;
    }

    public function getCancellationInitiatedBy() {
        return $this->cancellationInitiatedBy;
    }

    public function setCancellationInitiatedBy($s) {
        if (!in_array($s, array('staff', 'customer'))) {
            throw new \InvalidArgumentException("Invalid option for who initiated the cancellation");
        }
        $this->cancellationInitiatedBy = $s;
    }

        /**
     * @return Collection|Order[]
     */
    public function getOrderItems() {
        return $this->orderItems;
    }

    public function addOrderItem($orderitem) {
        if (!$this->orderitems->contains($orderitem)) {
            $this->orderItems[] = $orderitem;
            $orderitem->setOrder($this);
        }
    }

}
