<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\OneToMany(mappedBy: 'shop_id', targetEntity: Raport::class, orphanRemoval: true)]
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Raport>
     */
    public function getRaports(): Collection
    {
        return $this->raports;
    }

    public function addRaport(Raport $raport): self
    {
        if (!$this->raports->contains($raport)) {
            $this->raports->add($raport);
            $raport->setShopId($this);
        }

        return $this;
    }

    public function removeRaport(Raport $raport): self
    {
        if ($this->raports->removeElement($raport)) {
            // set the owning side to null (unless already changed)
            if ($raport->getShopId() === $this) {
                $raport->setShopId(null);
            }
        }

        return $this;
    }
}
