<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\ManyToOne(inversedBy: 'UserId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'ReportId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Report $Report = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;
        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeImmutable $Date): self
    {
        $this->Date = $Date;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;
        return $this;
    }

    public function getReport(): ?Report
    {
        return $this->Report;
    }

    public function setReport(?Report $Report): self
    {
        $this->Report = $Report;
        return $this;
    }
}
