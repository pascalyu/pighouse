<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitationRepository")
 */
class Invitation
{
    
    
    const STATE_WAITING   = "WAITING";
    const STATE_CONFIRMED = "CONFIRMED";
    const STATE_DECLINED = "DECLINED";
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pig", inversedBy="invitations")
     */
    private $pig_source;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pig", inversedBy="invitationsReceived")
     */
    private $pig_dest;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\House", inversedBy="invitations")
     */
    private $house;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, columnDefinition="ENUM('WAITING', 'CONFIRMED', 'DECLINED')")
     */
    private $state;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPigSource(): ?Pig
    {
       
        return $this->pig_source;
    }

    public function setPigSource(?Pig $pig_source): self
    {
        $this->pig_source = $pig_source;

        return $this;
    }

    public function getPigDest(): ?Pig
    {
        return $this->pig_dest;
    }

    public function setPigDest(?Pig $pig_dest): self
    {
        $this->pig_dest = $pig_dest;

        return $this;
    }

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(?House $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastUpdatedAt(): ?\DateTimeInterface
    {
        return $this->last_updated_at;
    }

    public function setLastUpdatedAt(?\DateTimeInterface $last_updated_at): self
    {
        $this->last_updated_at = $last_updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
