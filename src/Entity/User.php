<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Invitations::class)]
    private Collection $receiver;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Invitations::class)]
    private Collection $invitations;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: Invitations::class)]
    private Collection $invitationsReceived;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Invitations::class)]
    private Collection $InvitationsSender;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: Invitations::class)]
    private Collection $invitationsReceiver;

    #[ORM\OneToMany(mappedBy: 'sender_id', targetEntity: Invitations::class)]
    private Collection $getInvitationsSender;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: Invitations::class)]
    private Collection $getInvitationsReceiver;

    #[ORM\OneToMany(mappedBy: 'sender_id', targetEntity: Invitations::class)]
    private Collection $senderInvitations;

    #[ORM\OneToMany(mappedBy: 'receiver_id', targetEntity: Invitations::class)]
    private Collection $receiverInvitations;

    public function __construct()
    {
        $this->receiver = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->invitationsReceived = new ArrayCollection();
        $this->InvitationsSender = new ArrayCollection();
        $this->invitationsReceiver = new ArrayCollection();
        $this->getInvitationsSender = new ArrayCollection();
        $this->getInvitationsReceiver = new ArrayCollection();
        $this->senderInvitations = new ArrayCollection();
        $this->receiverInvitations = new ArrayCollection();
    }

    private $name = ''; // initialize $name as an empty string

public function __toString()
{
    return $this->name; // which is a string in any circumstance
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(Invitations $receiver): self
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver->add($receiver);
            $receiver->setSenderId($this);
        }

        return $this;
    }

    public function removeReceiver(Invitations $receiver): self
    {
        if ($this->receiver->removeElement($receiver)) {
            // set the owning side to null (unless already changed)
            if ($receiver->getSenderId() === $this) {
                $receiver->setSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitations $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations->add($invitation);
            $invitation->setSenderId($this);
        }

        return $this;
    }

    public function removeInvitation(Invitations $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getSenderId() === $this) {
                $invitation->setSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getInvitationsReceived(): Collection
    {
        return $this->invitationsReceived;
    }

    public function addInvitationsReceived(Invitations $invitationsReceived): self
    {
        if (!$this->invitationsReceived->contains($invitationsReceived)) {
            $this->invitationsReceived->add($invitationsReceived);
            $invitationsReceived->setReceiverId($this);
        }

        return $this;
    }

    public function removeInvitationsReceived(Invitations $invitationsReceived): self
    {
        if ($this->invitationsReceived->removeElement($invitationsReceived)) {
            // set the owning side to null (unless already changed)
            if ($invitationsReceived->getReceiverId() === $this) {
                $invitationsReceived->setReceiverId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getInvitationsSender(): Collection
    {
        return $this->InvitationsSender;
    }

    public function addInvitationsSender(Invitations $invitationsSender): self
    {
        if (!$this->InvitationsSender->contains($invitationsSender)) {
            $this->InvitationsSender->add($invitationsSender);
            $invitationsSender->setSenderId($this);
        }

        return $this;
    }

    public function removeInvitationsSender(Invitations $invitationsSender): self
    {
        if ($this->InvitationsSender->removeElement($invitationsSender)) {
            // set the owning side to null (unless already changed)
            if ($invitationsSender->getSenderId() === $this) {
                $invitationsSender->setSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getInvitationsReceiver(): Collection
    {
        return $this->invitationsReceiver;
    }

    public function addInvitationsReceiver(Invitations $invitationsReceiver): self
    {
        if (!$this->invitationsReceiver->contains($invitationsReceiver)) {
            $this->invitationsReceiver->add($invitationsReceiver);
            $invitationsReceiver->setReceiverId($this);
        }

        return $this;
    }

    public function removeInvitationsReceiver(Invitations $invitationsReceiver): self
    {
        if ($this->invitationsReceiver->removeElement($invitationsReceiver)) {
            // set the owning side to null (unless already changed)
            if ($invitationsReceiver->getReceiverId() === $this) {
                $invitationsReceiver->setReceiverId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getGetInvitationsSender(): Collection
    {
        return $this->getInvitationsSender;
    }

    public function addGetInvitationsSender(Invitations $getInvitationsSender): self
    {
        if (!$this->getInvitationsSender->contains($getInvitationsSender)) {
            $this->getInvitationsSender->add($getInvitationsSender);
            $getInvitationsSender->setSenderId($this);
        }

        return $this;
    }

    public function removeGetInvitationsSender(Invitations $getInvitationsSender): self
    {
        if ($this->getInvitationsSender->removeElement($getInvitationsSender)) {
            // set the owning side to null (unless already changed)
            if ($getInvitationsSender->getSenderId() === $this) {
                $getInvitationsSender->setSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getGetInvitationsReceiver(): Collection
    {
        return $this->getInvitationsReceiver;
    }

    public function addGetInvitationsReceiver(Invitations $getInvitationsReceiver): self
    {
        if (!$this->getInvitationsReceiver->contains($getInvitationsReceiver)) {
            $this->getInvitationsReceiver->add($getInvitationsReceiver);
            $getInvitationsReceiver->setReceiverId($this);
        }

        return $this;
    }

    public function removeGetInvitationsReceiver(Invitations $getInvitationsReceiver): self
    {
        if ($this->getInvitationsReceiver->removeElement($getInvitationsReceiver)) {
            // set the owning side to null (unless already changed)
            if ($getInvitationsReceiver->getReceiverId() === $this) {
                $getInvitationsReceiver->setReceiverId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getSenderInvitations(): Collection
    {
        return $this->senderInvitations;
    }

    public function addSenderInvitation(Invitations $senderInvitation): self
    {
        if (!$this->senderInvitations->contains($senderInvitation)) {
            $this->senderInvitations->add($senderInvitation);
            $senderInvitation->setSenderId($this);
        }

        return $this;
    }

    public function removeSenderInvitation(Invitations $senderInvitation): self
    {
        if ($this->senderInvitations->removeElement($senderInvitation)) {
            // set the owning side to null (unless already changed)
            if ($senderInvitation->getSenderId() === $this) {
                $senderInvitation->setSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitations>
     */
    public function getReceiverInvitations(): Collection
    {
        return $this->receiverInvitations;
    }

    public function addReceiverInvitation(Invitations $receiverInvitation): self
    {
        if (!$this->receiverInvitations->contains($receiverInvitation)) {
            $this->receiverInvitations->add($receiverInvitation);
            $receiverInvitation->setReceiverId($this);
        }

        return $this;
    }

    public function removeReceiverInvitation(Invitations $receiverInvitation): self
    {
        if ($this->receiverInvitations->removeElement($receiverInvitation)) {
            // set the owning side to null (unless already changed)
            if ($receiverInvitation->getReceiverId() === $this) {
                $receiverInvitation->setReceiverId(null);
            }
        }

        return $this;
    }
}
