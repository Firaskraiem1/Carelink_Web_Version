<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: "user")]
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    // #[ORM\GeneratedValue]
    #[ORM\Column(type: "string", length: 255, name: "email")]
    private ?string $id = null;

    #[ORM\Column(length: 255, name: 'firstname')]
    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    private ?string $nom = null;

    #[ORM\Column(length: 255, name: 'lastname')]
    #[Assert\NotBlank(message: "Le prenom est obligatoire")]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, unique: true, name: "image")]
    #[Assert\NotBlank(message: "L'email est obligatoire")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide.")]
    private ?string $email = null;

    #[ORM\Column(length: 255, name: 'password')]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire")]
    #[Assert\Length(
        min: 8,
        minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: '/^(?=.*[A-Z])(?=.*\d).+$/',
        message: 'Le mot de passe doit contenir au moins une majuscule et un chiffre.'
    )]
    private ?string $motDePasse = null;

    #[ORM\Column(length: 255)]
    // #[Assert\NotBlank(message: "]
    public ?string $role = null;

    // #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'user')]
    // private Collection $commentaires;

    // #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'idUser')]
    // private Collection $reclamations;

    #[ORM\Column(name: "access")]
    public ?bool $active = true;

    #[ORM\Column(length: 30, nullable: true)]
    public ?string $phone = null;



    public function __construct()
    {
        // $this->commentaires = new ArrayCollection();
        // $this->reclamations = new ArrayCollection();
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getUserIdentifier(): string
    {
        return $this->getId();
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    // public function getCommentaires(): Collection
    // {
    //     return $this->commentaires;
    // }

    // public function addCommentaire(Commentaire $commentaire): static
    // {
    //     if (!$this->commentaires->contains($commentaire)) {
    //         $this->commentaires->add($commentaire);
    //         $commentaire->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeCommentaire(Commentaire $commentaire): static
    // {
    //     if ($this->commentaires->removeElement($commentaire)) {
    //         // set the owning side to null (unless already changed)
    //         if ($commentaire->getUser() === $this) {
    //             $commentaire->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function getReclamation(): ?Reclamation
    // {
    //     return $this->reclamation;
    // }

    // public function setReclamation(?Reclamation $reclamation): static
    // {
    //     $this->reclamation = $reclamation;

    //     return $this;
    // }

    /**
     * @return Collection<int, Reclamation>
     */
    // public function getReclamations(): Collection
    // {
    //     return $this->reclamations;
    // }

    // public function addReclamation(Reclamation $reclamation): static
    // {
    //     if (!$this->reclamations->contains($reclamation)) {
    //         $this->reclamations->add($reclamation);
    //         $reclamation->setIdUser($this);
    //     }

    //     return $this;
    // }

    // public function removeReclamation(Reclamation $reclamation): static
    // {
    //     if ($this->reclamations->removeElement($reclamation)) {
    //         // set the owning side to null (unless already changed)
    //         if ($reclamation->getIdUser() === $this) {
    //             $reclamation->setIdUser(null);
    //         }
    //     }

    //     return $this;
    // }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}
