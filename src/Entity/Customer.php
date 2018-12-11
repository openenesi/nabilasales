<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @UniqueEntity(fields="cid", message="Customer Id must be unique")
 */
class Customer {

    use \App\Utility\Utils;
    use \App\Utility\NameUtils;

    public function __construct() {
        $dt = new \DateTime();
        $this->dateCreated = $dt;
        $this->orders = new ArrayCollection();
        $this->status = 'active';
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="customer_id", type="integer")
     */
    private $id;

    // add your own fields

    /**
     *
     * @ORM\Column(type="string", length=6, nullable=false, unique=true, options= {"default":"C00000"})
     */
    private $cid;

    /**
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $fname;

    /**
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $lname;

    /**
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $oname;

    /**
     *
     * @Assert\NotBlank(message="Cannot find registration date")
     * @Assert\Date(message = "Date of registration must be a valid date.")
     * @ORM\Column(type="date", nullable=false)
     */
    private $dateCreated;

    /**
     *
     * @Assert\Email(message="The email '{{value}}' is not a valid email address.")
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mobileNo;

    /**
     *
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private $address;

    /**
     *
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private $businessName;

    /**
     *
     * @Assert\Choice(callback="getUtilTitles", message="Invalid Title")
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $title;

    /**
     *
     * @Assert\Choice(callback= "getUtilCustomerStatus", message="Invalid status")
     * @ORM\Column(type="string", length=15, nullable=false, options={"default":"active"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="customer")
     */
    private $orders;

    public function getId() {
        return $this->id;
    }

    public function getCid() {
        return $this->cid;
    }

    public function setCid($cid) {
        $this->cid = $cid;
    }

    public function getFname() {
        return $this->fname;
    }

    public function setFname($fname) {
        $this->fname = trim($fname);
    }

    public function getLname() {
        return $this->lname;
    }

    public function setLname($lname) {
        $this->lname = trim($lname);
    }

    public function getOname() {
        return $this->oname;
    }

    public function setOname($oname) {
        $this->oname = trim($oname);
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($datecreated) {
        if (!isset($datecreated) || $datecreated == "") {
            $datecreated = new \DateTime();
        }
        $this->dateCreated = $datecreated;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = trim($email);
    }

    public function getMobileNo() {
        return $this->mobileNo;
    }

    public function setMobileNo($number) {
        $this->mobileNo = trim($number);
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($addr) {
        $this->address = trim($addr);
    }

    public function getBusinessName() {
        return $this->businessName;
    }

    public function setBusinessName($businessname) {
        $this->businessName = trim($businessname);
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $title = trim($title);
        if (!in_array($title, Customer::getUtilTitles())) {
            throw new \InvalidArgumentException("Invalid Title");
        }
        $this->title = $title;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $status = trim(strtolower($status));
        if (!in_array($status, Customer::getUtilCustomerStatus())) {
            throw new \InvalidArgumentException("Invalid Status");
        }
        $this->status = $status;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders() {
        return $this->orders;
    }

    public function addOrder($order) {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setOrder($this);
        }
    }

}
