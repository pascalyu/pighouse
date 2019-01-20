<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 */
class Action
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $actionType = [];

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_updated_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deleted_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\pig", inversedBy="actions")
     */
    private $pig_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\house", inversedBy="actions")
     */
    private $house_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionType(): ?array
    {
        return $this->actionType;
    }

    public function setActionType(array $actionType): self
    {
        $this->actionType = $actionType;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastUpdatedAt(): ?\DateTimeInterface
    {
        return $this->last_updated_at;
    }

    public function setLastUpdatedAt(\DateTimeInterface $last_updated_at): self
    {
        $this->last_updated_at = $last_updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getPigId(): ?pig
    {
        return $this->pig_id;
    }

    public function setPigId(?pig $pig_id): self
    {
        $this->pig_id = $pig_id;

        return $this;
    }

    public function getHouseId(): ?house
    {
        return $this->house_id;
    }

    public function setHouseId(?house $house_id): self
    {
        $this->house_id = $house_id;

        return $this;
    }
}
