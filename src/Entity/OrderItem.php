<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 */
class OrderItem {

    use \App\Utility\Utils;

    public function __construct() {
        $dt = new \DateTime();
        $this->dateCreated = $dt;
        $this->quantityDelivered = 0;
        $this->orderItemStatus = "pending";
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name= "order_item_id", type="integer")
     */
    private $id;
    // add your own fields

    /**
     * @Assert\NotBlank(message="Select a product")
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", nullable=false)
     */
    private $product;

    /**
     * @Assert\NotBlank(message="Specify the unit price")
     * @Assert\Type(type="numeric", message="Unit Price must be a numeric value.")
     * @Assert\GreaterThanOrEqual(value=0, message="Unit Price must be greater than or equal to 0.")
     * @ORM\Column(type="decimal", precision=15, scale=2, nullable=false, options={"unsigned":true})
     */
    private $unitPrice;

    /**
     * @Assert\NotBlank(message = "Specify the quantity")
     * @Assert\Type(type="numeric", message="Quantity must be a numeric value.")
     * @Assert\GreaterThan(value=0, message="Quantity must be greater than 0.")
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true})
     */
    private $quantityOrdered;

    /**
     * @Assert\NotBlank(message = "Specify the quantity")
     * @Assert\Type(type="numeric", message="Quantity must be a numeric value.")
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    private $quantityDelivered;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDelivered;

    /**
     * 
     * @ORM\Column(type="string", nullable=false, length=500)
     */
    private $deliveryAddress;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="delivery_entered_by", referencedColumnName="user_id", nullable=true)
     */
    private $deliveryEnteredBy;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $deliveryRemark;

    /**
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
     * @Assert\NotBlank()
     * @Assert\Choice(callback= "getUtilOrderItemStatus", message="Invalid Status")
     * @ORM\Column(type="string", nullable=false, length=20, options={"default":"pending"})
     */
    private $orderItemStatus;

    /**
     *
     * @Assert\NotBlank(message="Every order item must be match with an existing order.")
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="order_id", nullable=false)
     */
    private $order;

    public function getId() {
        return $this->id;
    }

    public function getQuantityOrdered() {
        return $this->quantityOrdered;
    }

    public function setQuantityOrdered($qty) {
        $this->quantityOrdered = $qty;
    }

    public function getQuantityDelivered() {
        return $this->quantityDelivered;
    }

    public function setQuantityDelivered($qty) {
        $this->quantityDelivered = $qty;
    }

    public function getUnitPrice() {
        return $this->unitPrice;
    }

    public function setUnitPrice($uprice) {
        $this->unitPrice = $uprice;
    }

    public function getOrder() {
        if(null === $this->order){
            $this->order = new Order();
        }
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product) {
        $this->product = $product;
    }

    public function getDeliveryAddress() {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress($loc) {
        $this->deliveryAddress = $loc;
    }

    public function getDeliveryEnteredBy() {
        return $this->deliveryEnteredBy;
    }

    public function setDeliveryEnteredBy($staff) {
        $this->deliveryEnteredBy = $staff;
    }

    public function getDateDelivered() {
        return $this->dateDelivered;
    }

    public function setDateDelivered($dt) {
        $this->dateDelivered = $dt;
    }

    public function getDeliveryRemark() {
        return $this->deliveryRemark;
    }

    public function setDeliveryRemark($delremark) {
        $this->deliveryRemark = $delremark;
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

    public function getOrderItemStatus() {
        return $this->orderItemStatus;
    }

    public function setOrderItemStatus($ostatus) {
        if (!in_array($ostatus, OrderItem::getUtilOrderItemStatus())) {
            throw new \InvalidArgumentException("Invalid Order Item Status");
        }
        $this->orderItemStatus = $ostatus;
    }

}
