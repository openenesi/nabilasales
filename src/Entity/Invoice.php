<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 * @UniqueEntity(fields="invRef", message="Invoice Ref must be unique")
 */
class Invoice {

    use \App\Utility\Utils;
    
    public function __construct() {
        $this->transactions = new ArrayCollection();
        $this->divertedtransactions = new ArrayCollection();
        $dt = new \DateTime();
        $this->dateCreated = $dt;
        $this->invoiceStatus = "draft";
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="invoice_id", type="integer")
     */
    private $id;

    // add your own fields

    /**
     *
     * @ORM\Column(type="integer", nullable=false, unique=true, options={"unsigned":true})
     */
    private $invRef;

    /**
     *
     * @Assert\NotBlank(message="Every invoice must be match with an existing order.")
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="order_id", nullable=false)
     */
    private $order;

    /**
     * @Assert\NotBlank(message="Date of entry unknown!")
     * @Assert\DateTime(message = "Date recorded must be a valid date with time.")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback= "getUtilInvoiceStatus", message="Invalid Order Status")
     * @ORM\Column(type="string", nullable=false, length=20, options={"default":"draft"})
     */
    private $invoiceStatus;

    /**
     *
     * @Assert\GreaterThanOrEqual(propertyPath="dateCreated", message="Date of cancellation must be on or after the date invoice was created.")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCancelled;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="cancelled_by", referencedColumnName="user_id", nullable=true)
     */
    private $cancelledBy;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $cancellationRemark;

    /**
     *
     * @Assert\GreaterThanOrEqual(propertyPath="dateCreated", message="Date of rejection must be on or after the date invoice was created.")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRejected;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="rejected_by", referencedColumnName="user_id", nullable=true)
     */
    private $rejectedBy;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $rejectionRemark;

    /**
     *
     * @Assert\GreaterThanOrEqual(propertyPath="dateCreated", message="Date of approval must be on or after the date invoice was created.")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateApproved;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="approved_by", referencedColumnName="user_id", nullable=true)
     */
    private $approvedBy;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $approvalRemark;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="invoice")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="invoice")
     */
    private $divertedtransactions;

    public function getId() {
        return $this->id;
    }

    public function getInvRef() {
        return $this->invRef;
    }

    public function setInvRef($invref) {
        $this->invRef = $invref;
    }

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dt) {
        $this->dateCreated = $dt;
    }

    public function getInvoiceStatus() {
        return $this->invoiceStatus;
    }

    public function setInvoiceStatus($invstatus) {
        if (!in_array($invstatus, Invoice::getUtilInvoiceStatus())) {
            throw new \InvalidArgumentException("Invalid Invoice Status");
        }
        $this->invoiceStatus = $invstatus;
    }

    public function getDateCancelled() {
        return $this->dateCancelled;
    }

    public function setDateCancelled($dt) {
        $this->dateCancelled = $dt;
    }

    public function getCancelledBy() {
        return $this->cancelledBy;
    }

    public function setCancelledBy($cancelledBy) {
        $this->cancelledBy = $cancelledBy;
    }

    public function getCancellationRemark() {
        return $this->cancellationRemark;
    }

    public function setCancellationRemark($cremark) {
        $this->cancellationRemark = $cremark;
    }

    public function getDateRejected() {
        return $this->dateRejected;
    }

    public function setDateRejected($dt) {
        $this->dateRejected = $dt;
    }

    public function getRejectedBy() {
        return $this->rejectedBy;
    }

    public function setRejectedBy($rejectedBy) {
        $this->rejectedBy = $rejectedBy;
    }

    public function getRejectionRemark() {
        return $this->rejectionRemark;
    }

    public function setRejectionRemark($rejremark) {
        $this->rejectionRemark = $rejremark;
    }

    public function getDateApproved() {
        return $this->dateApproved;
    }

    public function setDateApproved($dt) {
        $this->dateApproved = $dt;
    }

    public function getApprovedBy() {
        return $this->approvedBy;
    }

    public function setApprovedBy($approvedBy) {
        $this->approvedBy = $approvedBy;
    }

    public function getApprovalRemark() {
        return $this->approvalRemark;
    }

    public function setApprovalRemark($appremark) {
        $this->approvalRemark = $appremark;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions() {
        return $this->transactions;
    }

    public function addTransaction($transaction) {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setInvoice($this);
        }
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDivertedTransactions() {
        return $this->divertedtransactions;
    }

    public function addDivertedTransaction($transaction) {
        if (!$this->divertedtransactions->contains($transaction)) {
            $this->divertedtransactions[] = $transaction;
            $transaction->setInvoice($this);
        }
    }

}
