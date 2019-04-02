<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 * @ExclusionPolicy("all")
 */
class Action {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Expose
     */
    private $actionType;

    /**
     * 
     * @ORM\Column(type="float", nullable=true)
     *  @Expose
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Expose
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     * @Expose
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Expose
     */
    private $last_updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Expose
     */
    private $deleted_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\pig", inversedBy="actions")
     * 
     */
    private $pig;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\house", inversedBy="actions")
     */
    private $house;
    private $colorClass;

    public function getColorClass(): ?string {
        $result = "red";
        if ($this->actionType === "ADD") {

            $result = "green";
        }
        $this->colorClass = $result;
        return $result;
    }

    public function setColorClass(): ?string {
        return $this->actionType;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getActionType(): ?string {
        return $this->actionType;
    }

    public function setActionType(?string $actionType): self {
        $this->actionType = $actionType;

        return $this;
    }

    public function getAmount(): ?float {
        return $this->amount;
    }

    public function setAmount(?float $amount): self {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?DateTimeInterface {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date): self {
        $this->date = $date;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastUpdatedAt(): ?DateTimeInterface {
        return $this->last_updated_at;
    }

    public function setLastUpdatedAt(DateTimeInterface $last_updated_at): self {
        $this->last_updated_at = $last_updated_at;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeInterface {
        return $this->deleted_at;
    }

    public function setDeletedAt(DateTimeInterface $deleted_at): self {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getPig(): ?pig {
        return $this->pig;
    }

    public function setPig(?pig $pig): self {
        $this->pig = $pig;

        return $this;
    }

    public function getHouse(): ?house {
        return $this->house;
    }

    public function setHouse(?house $house): self {
        $this->house = $house;

        return $this;
    }

}
