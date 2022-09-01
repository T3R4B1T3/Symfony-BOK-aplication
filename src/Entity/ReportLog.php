<?php

namespace App\Entity;

use App\Repository\ReportLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportLogRepository::class)]
class ReportLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $seen = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_who_read = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $read_date = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\OneToOne(mappedBy: 'report_log', cascade: ['persist', 'remove'])]
    private ?Report $report = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $read): self
    {
        $this->seen = $read;

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

    public function getReport(): ?Report
    {
        return $this->report;
    }

    public function setReport(Report $report): self
    {
        // set the owning side of the relation if necessary
        if ($report->getReportLog() !== $this) {
            $report->setReportLog($this);
        }

        $this->report = $report;

        return $this;
    }
}
