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

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Raport::class, orphanRemoval: true)]
    private Collection $raports;

    public function __construct()
    {
        $this->raports = new ArrayCollection();
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
     * @return Collection<int, Raport>
     */
    public function getRaports(): Collection
    {
        return $this->raports;
    }

    public function addRaports(Raport $raports): self
    {
        if (!$this->raports->contains($raports)) {
            $this->raports->add($raports);
            $raports->setCategoryId($this);
        }

        return $this;
    }

    public function removeRaports(Raport $raports): self
    {
        if ($this->raports->removeElement($raports)) {
            // set the owning side to null (unless already changed)
            if ($raports->getCategoryId() === $this) {
                $raports->setCategoryId(null);
            }
        }

        return $this;
    }
}
