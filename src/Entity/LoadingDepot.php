<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\LoadingDepotRepository")
 * @UniqueEntity(fields="depotName", message="Name of loading depot must be unique")
 */
class LoadingDepot {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="depot_id", type="integer")
     */
    private $id;

    // add your own fields

    /**
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false, unique=true, length=30)
     */
    private $depotName;

    //functions

    public function getId() {
        return $this->id;
    }

    public function getDepotName() {
        return $this->depotName;
    }

    public function setDepotName($name) {
        $this->depotName = trim($name);
    }

}
