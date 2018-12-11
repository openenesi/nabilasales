<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoadingRepository")
 * @ORM\Table(name="loading")
 */
class Loading {

    use \App\Utility\Utils;

    public function __construct() {
        $dt = new \DateTime();
        $this->dateCreated = $dt;
        $this->loadingDate = $dt;
        $this->quantityReceived = 0;
        $this->loadingStatus= "on-transit";
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="loading_id", type="integer")
     */
    private $id;
    // add your own fields

    /**
     *
     * @Assert\NotBlank(message="Unknown date of entry.")
     * @Assert\DateTime(message = "Date created must be a valid date with time.")
     * @Assert\GreaterThanOrEqual(propertyPath="loadingDate", message="Date Created must be a date on or after the actual loading date.")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     *
     * @Assert\NotBlank(message="Unknown date of loading.")
     * @Assert\DateTime(message = "Loading date must be a valid date with time.")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $loadingDate;

    /**
     *
     * @Assert\NotBlank(message="Select loading depot.")
     * @ORM\ManyToOne(targetEntity="App\Entity\LoadingDepot")
     * @ORM\JoinColumn(name="depot_id", referencedColumnName="depot_id", nullable=true)
     */
    private $loadingDepot;

    /**
     * 
     * @Assert\NotBlank(message="Select a product")
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", nullable=false)
     */
    private $product;

    /**
     *
     * @Assert\NotBlank(message = "Specify the quantity loaded")
     * @Assert\Type(type="numeric", message="Quantity must be a numeric value.")
     * @Assert\GreaterThan(value=0, message="Quantity must be greater than 0.")
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true})
     */
    private $quantity;

    /**
     *
     * @Assert\NotBlank(message = "Specify the quantity loaded")
     * @Assert\Type(type="numeric", message="Quantity must be a numeric value.")
     * @Assert\LessThanOrEqual(propertyPath="quantity", message="Quantity received cannot be greater than quantity loaded.")
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    private $quantityReceived;

    /**
     *
     * @Assert\NotBlank(message="Specify the purchase price")
     * @Assert\Type(type="numeric", message="Purchase Price must be a numeric value.")
     * @Assert\GreaterThan(value=0, message="Purchase Price must be greater than 0.")
     * @ORM\Column(type="decimal", precision=15, scale=2, nullable=false, options={"unsigned":true})
     */
    private $purchaseRate;

    /**
     *
     * @Assert\NotBlank(message="Specify truck number.")
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $truckNumber;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $driverName;

    /**
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $driverMobileNo;

    /**
     *
     * @Assert\NotBlank(message="Specify Destination")
     * @ORM\Column(type="string", length=300, nullable=false)
     */
    private $destination;

    /**
     *
     * @Assert\NotBlank(message="Specify meter ticket no.")
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $meterTicket;

    /**
     *
     * @Assert\NotBlank(message="Specify L/H")
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $lh;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $lhReceived;

    /**
     *
     * @Assert\NotBlank(message="Specify O/H")
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $oh;

    /**
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ohReceived;

    /**
     *
     * @Assert\NotBlank(message="Specify Ullage")
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $ullage;

    /**
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ullageReceived;

    /**
     * 
     * @Assert\NotBlank(message="Select User")
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="user_id", nullable=false)
     */
    private $createdBy;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="received_by", referencedColumnName="user_id", nullable=true)
     */
    private $receivedBy;

    /**
     *
     * @Assert\DateTime(message = "Date received must be a valid date with time.")
     * @Assert\GreaterThanOrEqual(propertyPath="loadingDate", message="Date Received must be a date on or after the actual loading date.")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateReceived;

    /**
     * @Assert\Choice(callback= "getUtilLoadingStatus", message="Invalid Loading Status")
     * @ORM\Column(type="string", nullable=false, length=20, options={"default":"on-transit"})
     */
    private $loadingStatus;

    public function getId() {
        return $this->id;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($datecreated) {
        $this->dateCreated = $datecreated;
    }

    public function getDateReceived() {
        return $this->dateReceived;
    }

    public function setDateReceived($datereceived) {
        $this->dateReceived = $datereceived;
    }

    public function getLoadingDate() {
        return $this->loadingDate;
    }

    public function setLoadingDate($loadingdate) {
        $this->loadingDate = $loadingdate;
    }

    public function getCreatedBy() {
        return $this->createdBy;
    }

    public function setCreatedBy($sperson) {
        $this->createdBy = $sperson;
    }

    public function getReceivedBy() {
        return $this->receivedBy;
    }

    public function setReceivedBy($sperson) {
        $this->receivedBy = $sperson;
    }

    public function getLoadingStatus() {
        return $this->loadingStatus;
    }

    public function setLoadingStatus($lstatus) {
        if (!in_array($lstatus, Loading::getUtilLoadingStatus())) {
            throw new \InvalidArgumentException("Invalid Loading Status");
        }
        $this->loadingStatus = $lstatus;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($qty) {
        $this->quantity = $qty;
    }

    public function getQuantityReceived() {
        return $this->quantityReceived;
    }

    public function setQuantityReceived($qty) {
        $this->quantityReceived = $qty;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product) {
        $this->product = $product;
    }

    public function getPurchaseRate() {
        return $this->purchaseRate;
    }

    public function setPurchaseRate($uprice) {
        $this->purchaseRate = $uprice;
    }

    public function getTruckNumber() {
        return $this->truckNumber;
    }

    public function setTruckNumber($truckno) {
        $this->truckNumber = $truckno;
    }

    public function getDriverName() {
        return $this->driverName;
    }

    public function setDriverName($name) {
        $this->driverName = $name;
    }

    public function getDriverMobileNo() {
        return $this->driverMobileNo;
    }

    public function setDriverMobileNo($no) {
        $this->driverMobileNo = $no;
    }

    public function getDestination() {
        return $this->destination;
    }

    public function setDestination($dest) {
        $this->destination = $dest;
    }

    public function getMeterTicket() {
        return $this->meterTicket;
    }

    public function setMeterTicket($ticket) {
        $this->meterTicket = $ticket;
    }

    public function getLh() {
        return $this->lh;
    }

    public function setLh($lh) {
        $this->lh = $lh;
    }

    public function getLhReceived() {
        return $this->lhReceived;
    }

    public function setLhReceived($lhReceived) {
        $this->lhReceived = $lhReceived;
    }

    public function getOh() {
        return $this->oh;
    }

    public function setOh($oh) {
        $this->oh = $oh;
    }

    public function getOhReceived() {
        return $this->ohReceived;
    }

    public function setOhReceived($ohReceived) {
        $this->ohReceived = $ohReceived;
    }

    public function getUllage() {
        return $this->ullage;
    }

    public function setUllage($ullage) {
        $this->ullage = $ullage;
    }

    public function getUllageReceived() {
        return $this->ullageReceived;
    }

    public function setUllageReceived($ullageReceived) {
        $this->ullageReceived = $ullageReceived;
    }

    public function getLoadingDepot() {
        return $this->loadingDepot;
    }

    public function setLoadingDepot($depot) {
        $this->loadingDepot = $depot;
    }

}
