<?php

namespace App\Entity;

use App\Repository\RaportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaportRepository::class)]
class Raport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $raport_date = null;

    #[ORM\Column(length: 255)]
    private ?string $user_agent = null;

    #[ORM\ManyToOne(inversedBy: 'raports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'raports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shop $shop = null;

    #[ORM\OneToOne(inversedBy: 'raport', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?RaportLog $raport_log = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getRaportDate(): ?\DateTimeInterface
    {
        return $this->raport_date;
    }

    public function setRaportDate(\DateTimeInterface $raport_date): self
    {
        $this->raport_date = $raport_date;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }

    public function setUserAgent(string $user_agent): self
    {
        $this->user_agent = $user_agent;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getRaportLog(): ?RaportLog
    {
        return $this->raport_log;
    }

    public function setRaportLog(RaportLog $raport_log): self
    {
        $this->raport_log = $raport_log;

        return $this;
    }
}
