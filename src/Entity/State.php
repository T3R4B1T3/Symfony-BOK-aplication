<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateRepository::class)]
class State
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'state', targetEntity: ReportLog::class, orphanRemoval: true)]
    private Collection $reportLogs;

    public function __construct()
    {
        $this->reportLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ReportLog>
     */
    public function getReportLogs(): Collection
    {
        return $this->reportLogs;
    }

    public function addReportLog(ReportLog $reportLog): self
    {
        if (!$this->reportLogs->contains($reportLog)) {
            $this->reportLogs->add($reportLog);
            $reportLog->setState($this);
        }

        return $this;
    }

    public function removeReportLog(ReportLog $reportLog): self
    {
        if ($this->reportLogs->removeElement($reportLog)) {
            // set the owning side to null (unless already changed)
            if ($reportLog->getState() === $this) {
                $reportLog->setState(null);
            }
        }

        return $this;
    }
}
