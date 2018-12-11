<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product {
    use \App\Utility\Utils;    

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="product_id", type="integer")
     */
    private $id;

    // add your own fields

    /**
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false, unique=true, length=30)
     */
    private $productName;

    /**
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric", message="Unit Price must be a numeric value.")
     * @Assert\GreaterThan(value=0, message="Unit Price must be greater than 0.")
     * @ORM\Column(type="decimal", precision=15, scale=2, nullable=false, options={"unsigned":true})
     */
    private $unitPrice;

    /**
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false, length=10)
     */
    private $productCode;

    //functions

    public function getId() {
        return $this->id;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($pname) {
        $this->productName = trim($pname);
    }

    public function getUnitPrice() {
        return $this->unitPrice;
    }

    public function setUnitPrice($uprice) {
        $this->unitPrice = $uprice;
    }

    public function getProductCode() {
        return $this->productCode;
    }

    public function setProductCode($pcode) {
        $this->productCode = trim($pcode);
    }

}
