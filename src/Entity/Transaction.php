<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @UniqueEntity(fields="tRef", message="Transaction Ref must be unique")
 * @ORM\Table(name="payment")
 */
class Transaction {

    use \App\Utility\Utils;

    public function __construct() {
        $dt = new \DateTime();
        $this->dateCreated = $dt;
        $this->transDate = $dt;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="transaction_id", type="integer")
     */
    private $id;
    // add your own fields

    /**
     *
     * @ORM\Column(type="integer", nullable=false, unique=true, options={"unsigned":true})
     */
    private $tRef;

    /**
     *
     * @Assert\NotBlank(message="Transaction Date must be specified.")
     * @Assert\DateTime(message = "Transaction Date must be a valid date with time.")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $transDate;

    /**
     *
     * @Assert\NotBlank(message="Unknown date of entry.")
     * @Assert\DateTime(message = "Date recorded must be a valid date with time.")
     * @Assert\GreaterThanOrEqual(propertyPath="transDate", message="Date Recorded must be a date on or after the actual transaction date.")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     *
     * @Assert\NotBlank(message="Payments must be applied to an invoice")
     * @ORM\ManyToOne(targetEntity="App\Entity\Invoice", inversedBy="transactions")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="invoice_id", nullable=false)
     */
    private $invoice;

    /**
     *
     * @Assert\NotBlank(message="Invalid amount paid.")
     * @Assert\Type(type="numeric", message="Amount Paid must be a numeric value.")
     * @Assert\GreaterThan(value=0, message="Amount Paid must be greater than 0.")
     * @ORM\Column(type="decimal", precision=15, scale=2, nullable=false)
     */
    private $amountPaid;

    /**
     * @Assert\NotBlank(message="Select Payment Method")
     * @Assert\Choice(callback="getUtilPaymentOptions", message="Invalid Payment Method")
     * @ORM\Column(type="string", length=30, nullable = false)
     */
    private $paymentMethod;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $paymentDescription;

    /**
     * 
     * @Assert\NotBlank(message="select user")
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="received_by", referencedColumnName="user_id", nullable=false)
     */
    private $receivedBy;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback= "getUtilPaymentStatus", message="Invalid Payment Status")
     * @ORM\Column(type="string", nullable=false, length=20, options={"default":"accepted"})
     */
    private $paymentStatus;

    /**
     *
     * @Assert\GreaterThanOrEqual(propertyPath="dateCreated", message="Date of cancellation must be on or after the transaction was recorded.")
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
     * @Assert\GreaterThanOrEqual(propertyPath="transDate", message="Date of refund must be on or after the date of transaction.")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRefunded;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="refunded_by", referencedColumnName="user_id", nullable=true)
     */
    private $refundedBy;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $refundRemark;

    /**
     *
     * @Assert\GreaterThanOrEqual(propertyPath="transDate", message="Date of fund diversion must be on or after the date of transaction.")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDiverted;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="diverted_by", referencedColumnName="user_id", nullable=true)
     */
    private $divertedBy;

    /**
     *
     * @ORM\Column(type="string", nullable=true, length=500)
     */
    private $diversionRemark;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Invoice", inversedBy="divertedtransactions")
     * @ORM\JoinColumn(name="diverted_to", referencedColumnName="invoice_id", nullable=true)
     */
    private $divertedTo;

    public function getId() {
        return $this->id;
    }

    public function getTRef() {
        return $this->tRef;
    }

    public function setTRef($tRef) {
        $this->tRef = $tRef;
    }

    public function getTransDate() {
        return $this->transDate;
    }

    public function setTransDate($transDate) {
        $this->transDate = $transDate;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($datecreated) {
        $this->dateCreated = $datecreated;
    }

    public function getInvoice() {
        return $this->invoice;
    }

    public function setInvoice($invoice) {
        $this->invoice = $invoice;
    }

    public function getAmountPaid() {
        return $this->amountPaid;
    }

    public function setAmountPaid($amtpaid) {
        $this->amountPaid = $amtpaid;
    }

    public function getReceivedBy() {
        return $this->receivedBy;
    }

    public function setReceivedBy($sperson) {
        $this->receivedBy = $sperson;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    public function setPaymentMethod($pmethod) {
        $pmethod = trim(strtolower($pmethod));
        if (!in_array($pmethod, Transaction::getUtilPaymentOptions())) {
            throw new \InvalidArgumentException("Invalid Payment Method!");
        }
        $this->paymentMethod = $pmethod;
    }

    public function getPaymentDescription() {
        return $this->paymentDescription;
    }

    public function setPaymentDescription($desc) {
        $this->paymentDescription = $desc;
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

    public function getDateRefunded() {
        return $this->dateRefunded;
    }

    public function setDateRefunded($dt) {
        $this->dateRefunded = $dt;
    }

    public function getRefundedBy() {
        return $this->refundedBy;
    }

    public function setRefundedBy($refundedBy) {
        $this->refundedBy = $refundedBy;
    }

    public function getRefundRemark() {
        return $this->refundRemark;
    }

    public function setRefundRemark($cremark) {
        $this->refundRemark = $cremark;
    }

    public function getDateDiverted() {
        return $this->dateDiverted;
    }

    public function setDateDiverted($dt) {
        $this->dateDiverted = $dt;
    }

    public function getDivertedBy() {
        return $this->divertedBy;
    }

    public function setDivertedBy($divertedBy) {
        $this->divertedBy = $divertedBy;
    }

    public function getDiversionRemark() {
        return $this->diversionRemark;
    }

    public function setDiversionRemark($cremark) {
        $this->diversionRemark = $cremark;
    }

    public function getDivertedTo() {
        return $this->divertedTo;
    }

    public function setDivertedTo($invoice) {
        $this->divertedTo = $invoice;
    }

    public function getPaymentStatus() {
        return $this->paymentStatus;
    }

    public function setPaymentStatus($status) {
        $status = trim(strtolower($status));
        if (!in_array($status, Transaction::getUtilPaymentStatus())) {
            throw new \InvalidArgumentException("Invalid Payment Status!");
        }
        $this->paymentStatus = $status;
    }

    /* public function getData() {
      $data = array();
      if (isset($this->id)) {
      $data['id'] = $this->id;
      }
      if (isset($this->tid)) {
      $data['tid'] = $this->tid;
      }
      $data['transDate'] = $this->transDate;
      $data['order'] = $this->order;
      $data['paymentMethod'] = $this->paymentMethod;
      $data['committedBy'] = $this->committedBy;
      $data['amountPaid'] = $this->amountPaid;
      $data['dateRecorded'] = $this->dateRecorded;
      return $data;
      }
     */
}
