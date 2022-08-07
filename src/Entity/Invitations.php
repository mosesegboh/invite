<?php

namespace App\Entity;

use App\Repository\InvitationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvitationsRepository::class)]
class Invitations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /* 
    *@Assert\NotBlank
    *@Assert\Length(min=3)
    */ 
    #[ORM\Column(length: 255, nullable: true)]
    public ?string $subject = null;

    /* 
    *@Assert\NotBlank
    *@Assert\Length(min=3)
    */
    #[ORM\Column(length: 255, nullable: true)]
    public ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'senderInvitations', cascade: ['persist'])]
    private ?User $sender_id = null;

    #[ORM\ManyToOne(inversedBy: 'receiverInvitations', cascade: ['persist'])]
    private ?User $receiver_id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $status = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $acceptance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSenderId(): ?User
    {
        return $this->sender_id;
    }

    public function setSenderId(?User $sender_id): self
    {
        $this->sender_id = $sender_id;

        return $this;
    }

    public function getReceiverId(): ?User
    {
        return $this->receiver_id;
    }

    public function setReceiverId(?User $receiver_id): self
    {
        $this->receiver_id = $receiver_id;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAcceptance(): ?int
    {
        return $this->acceptance;
    }

    public function setAcceptance(?int $acceptance): self
    {
        $this->acceptance = $acceptance;

        return $this;
    }
}
