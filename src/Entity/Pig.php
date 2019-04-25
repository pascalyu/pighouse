<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PigRepository")
 */
class Pig implements UserInterface {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     *  )
     */
    private $pseudoName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\House", mappedBy="pigs")
     * 
     */
    private $houses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitation", mappedBy="pig_source")
     */
    private $invitations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitation", mappedBy="pig_dest")
     */
    private $invitationsReceived;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Action", mappedBy="pig_id")
     */
    private $actions;

    public function __construct() {
        $this->houses = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPseudoName(): ?string {
        return $this->pseudoName;
    }

    public function setPseudoName(string $pseudoName): self {
        $this->pseudoName = $pseudoName;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastUpdatedAt(): ?\DateTimeInterface {
        return $this->lastUpdatedAt;
    }

    public function setLastUpdatedAt(?\DateTimeInterface $lastUpdatedAt): self {
        $this->lastUpdatedAt = $lastUpdatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|House[]
     */
    public function getHouses(): Collection {
        return $this->houses;
    }
    public function getJoinedHouse(){
        
        if(!$this->hasHouse()){
            return $this->getHouse();
        }
        
        foreach($this->getHouses() as $joinedHouse){
            return $joinedHouse;
        }
    }

    public function addHouse(House $house): self {
        if (!$this->houses->contains($house)) {
            $this->houses[] = $house;
            $house->addPig($this);
        }

        return $this;
    }

    public function removeHouse(House $house): self {
        if ($this->houses->contains($house)) {
            $this->houses->removeElement($house);
            $house->removePig($this);
        }

        return $this;
    }

    public function hasHouse() {
        return (count($this->houses) > 0);
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(?string $username): self {
        $this->username = $username;
        return $this;
    }

    public function getRoles() {
        return ['ROLE_USER'];
    }

    public function getSalt() {
        
    }

    public function eraseCredentials() {
        
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitations(): Collection {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setPigSource($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self {
        if ($this->invitations->contains($invitation)) {
            $this->invitations->removeElement($invitation);
            // set the owning side to null (unless already changed)
            if ($invitation->getPigSource() === $this) {
                $invitation->setPigSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitationsReceived(): Collection {
        return $this->invitations;
    }

    public function addInvitationReceived(Invitation $invitation): self {
        if (!$this->invitationsReceived->contains($invitation)) {
            $this->invitationsReceived[] = $invitation;
            $invitation->setPigDest($this);
        }

        return $this;
    }

    public function removeInvitationReceived(Invitation $invitation): self {
        if ($this->invitationsReceived->contains($invitation)) {
            $this->invitationsReceived->removeElement($invitation);
            // set the owning side to null (unless already changed)
            if ($invitation->getPigDest() === $this) {
                $invitation->setPigDest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection {
        return $this->actions;
    }

    public function addAction(Action $action): self {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setPigId($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getPigId() === $this) {
                $action->setPigId(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->pseudoName;
    }
    public function setHouses($houses){
        
        $this->houses= $houses;
    }
     public function setActions($actions){
        
        $this->actions= $actions;
    }
    
   
}
