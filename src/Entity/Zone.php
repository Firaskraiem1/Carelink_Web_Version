<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "la ville ne peut pas être vide.")]
    private ?string $ville = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "le rue ne peut pas être vide.")]
    #[Assert\Range(
        min: 1,
        notInRangeMessage: "rue ne peut pas être négatif"
    )]
    private ?int $numRue = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: ParaPharmacie::class)]
private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }
    
    public function getId(): ?string
    {
        return $this->id;
    }
    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNumRue(): ?int
    {
        return $this->numRue;
    }

    public function setNumRue(int $numRue): static
    {
        $this->numRue = $numRue;

        return $this;
    }

    /**
     * @return Collection<int, ParaPharmacie>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(ParaPharmacie $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setVille($this);
        }

        return $this;
    }

    public function removeRelation(ParaPharmacie $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getVille() === $this) {
                $relation->setVille(null);
            }
        }

        return $this;
    }
}
