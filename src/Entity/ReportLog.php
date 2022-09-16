<?php

namespace App\Entity;

use App\Repository\ReportLogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(mappedBy: 'report_log', cascade: ['persist', 'remove'])]
    private ?Report $report = null;

    #[ORM\ManyToOne(inversedBy: 'reportLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?State $state = null;

    #[ORM\OneToMany(mappedBy: 'reportLog', targetEntity: Comment::class)]
    private Collection $comments;

    public function __toString() {
        return strval($this->id);
    }

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setReportLog($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getReportLog() === $this) {
                $comment->setReportLog(null);
            }
        }

        return $this;
    }
}
