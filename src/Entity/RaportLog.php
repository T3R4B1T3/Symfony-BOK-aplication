<?php

namespace App\Entity;

use App\Repository\RaportLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaportLogRepository::class)]
class RaportLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $read = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_who_read = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $read_date = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\OneToOne(mappedBy: 'raport_log_id', cascade: ['persist', 'remove'])]
    private ?Raport $raport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isRead(): ?bool
    {
        return $this->read;
    }

    public function setRead(bool $read): self
    {
        $this->read = $read;

        return $this;
    }

    public function getFirstWhoRead(): ?string
    {
        return $this->first_who_read;
    }

    public function setFirstWhoRead(?string $first_who_read): self
    {
        $this->first_who_read = $first_who_read;

        return $this;
    }

    public function getReadDate(): ?\DateTimeInterface
    {
        return $this->read_date;
    }

    public function setReadDate(?\DateTimeInterface $read_date): self
    {
        $this->read_date = $read_date;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getRaport(): ?Raport
    {
        return $this->raport;
    }

    public function setRaport(Raport $raport): self
    {
        // set the owning side of the relation if necessary
        if ($raport->getRaportLogId() !== $this) {
            $raport->setRaportLogId($this);
        }

        $this->raport = $raport;

        return $this;
    }
}
