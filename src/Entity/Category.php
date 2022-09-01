<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Report::class, orphanRemoval: true)]
    private Collection $reports;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
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
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReports(Report $reports): self
    {
        if (!$this->reports->contains($reports)) {
            $this->reports->add($reports);
            $reports->setCategory($this);
        }

        return $this;
    }

    public function removeReports(Report $reports): self
    {
        if ($this->reports->removeElement($reports)) {
            // set the owning side to null (unless already changed)
            if ($reports->getCategory() === $this) {
                $reports->setCategory(null);
            }
        }

        return $this;
    }
}
