<?php

namespace App\Entity;

use App\Repository\ParaPharmacieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Vich\Uploadable;  
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use DateTimeImmutable;
#[ORM\Entity(repositoryClass: ParaPharmacieRepository::class)]
#[Vich\Uploadable]
class ParaPharmacie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la parapharmacie ne peut pas être vide.")]
    private ?string $nomPara = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^[^@]+@(gmail|yahoo|outlook)\.(com|fr|tn)$/",
        message: "Veuillez saisir une adresse e-mail valide (domaine gmail, yahoo ou outlook uniquement)."
    )] 
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le nombre de pharmaciens ne peut pas être vide.")]
    #[Assert\Range(
        min: 1,
        max: 20,
        notInRangeMessage: "Le nombre de pharmaciens doit être compris entre {{ min }} et {{ max }}."
    )]
    private ?int $nbrPharmaciens = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le numéro de téléphone ne peut pas être vide.")]
    #[Assert\Range(
        min: 10000000,
        max: 99999999,
        notInRangeMessage: "Le numéro de téléphone doit être 8 chiffres"
    )]
    private ?int $numtel = null;


    #[ORM\ManyToOne(inversedBy: 'relation',cascade:['remove'])]
    private ?Zone $ville;

     // NOTE: This is not a mapped field of entity metadata, just a simple property.
     #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
     private ?File $imageFile = null;
 
     #[ORM\Column(nullable: true)]
     private ?string $imageName = null;
     
     #[ORM\Column(type:'datetime_immutable')]
     protected $updatedAt;

     #[ORM\Column(length: 50)]
     #[Assert\NotNull(message: "Le numéro de téléphone ne peut pas être vide.")]
     private ?string $latitude ;

     #[ORM\Column(length: 50)]
     #[Assert\NotNull(message: "Le numéro de téléphone ne peut pas être vide.")]
     private ?string $longitude ;

     #[ORM\Column(length: 255)]
     #[Assert\NotNull(message: "Le numéro de téléphone ne peut pas être vide.")]
     private ?string $typePara = null;

     #[ORM\Column(type: Types::TIME_MUTABLE)]
     
     private ?\DateTimeInterface $horraire_ouverture = null;

     #[ORM\Column(type: Types::TIME_MUTABLE)]
     private ?\DateTimeInterface $horraire_fermeture = null;

     
     public function __construct() {
       $this->updatedAt = new DateTimeImmutable();
       $this->ville = null;
       $this->latitude = null;
       $this->longitude = null;
     }
   
     public function getUpdatedAt(): ?DateTimeImmutable
     {
       return $this->updatedAt;
     }
   
     public function setUpdatedAt(DateTimeImmutable $updatedAt): self
     {
       $this->updatedAt = $updatedAt;
   
       return $this;
     }
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPara(): ?string
    {
        return $this->nomPara;
    }

    public function setNomPara(string $nomPara): static
    {
        $this->nomPara = $nomPara;

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

    public function getNbrPharmaciens(): ?int
    {
        return $this->nbrPharmaciens;
    }

    public function setNbrPharmaciens(int $nbrPharmaciens): static
    {
        $this->nbrPharmaciens = $nbrPharmaciens;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

   

    public function getVille(): ?Zone
    {
        return $this->ville;
    }

    public function setVille(?Zone $ville): static
    {
        $this->ville = $ville;

        return $this;
    }
  /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $image = null)
    {
    $this->imageFile = $image;

     if ($image) {
         // generate a unique file name
         $this->imageName = uniqid('', true) . '.' . $image->guessExtension();
     }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getTypePara(): ?string
    {
        return $this->typePara;
    }

    public function setTypePara(string $typePara): static
    {
        $this->typePara = $typePara;

        return $this;
    }

    public function getHorraireOuverture(): ?\DateTimeInterface
    {
        return $this->horraire_ouverture;
    }

    public function setHorraireOuverture(\DateTimeInterface $horraire_ouverture): static
    {
        $this->horraire_ouverture = $horraire_ouverture;

        return $this;
    }

    public function getHorraireFermeture(): ?\DateTimeInterface
    {
        return $this->horraire_fermeture;
    }

    public function setHorraireFermeture(\DateTimeInterface $horraire_fermeture): static
    {
        $this->horraire_fermeture = $horraire_fermeture;

        return $this;
    }

   
}
