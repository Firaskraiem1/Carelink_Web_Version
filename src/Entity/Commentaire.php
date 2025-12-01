<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    private ?Evenement $evenement = null;

    // #[ORM\ManyToOne(inversedBy: 'commentaires')]
    // private ?Utilisateur $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

   
   

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }

    // public function getUser(): ?Utilisateur
    // {
    //     return $this->user;
    // }

    // public function setUser(?Utilisateur $user): static
    // {
    //     $this->user = $user;

    //     return $this;
    // }
}
