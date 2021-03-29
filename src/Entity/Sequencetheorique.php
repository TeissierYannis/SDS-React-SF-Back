<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 * Sequencetheorique
 *
 * @ORM\Table(name="sequencetheorique")
 * @ORM\Entity
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_USER')"},
 *     normalizationContext={"groups"={"sequence:lecture"}},
 *     itemOperations={
 *          "get"={
 *                  "security"="is_granted('ROLE_USER')",
 *                  "normalization_context"={"groups"={"sequence:lecture"}},
 *          },
 *          "patch"={
 *                  "security"="object.getProprietaire() == user"
 *          },
 *          "delete"={
 *                  "security"="object.getProprietaire() == user"
 *          },
 *          "customer_action"={
 *                  "method"="post",
 *                  "security"="is_granted('ROLE_USER')",
 *                  "route_name"="ajouterSequencetheorique_route"
 *          },
 *     }
 * )
 */
class Sequencetheorique
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups("sequence:lecture")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="text", length=65535, nullable=false)
     *
     * @Groups("sequence:lecture")
     */
    private $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="niveau", type="integer", nullable=false)
     *
     * @Groups("sequence:lecture")
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=Activitesequencetheorique::class, mappedBy="idsequencetheorique", orphanRemoval=true)
     * @Groups("sequence:lecture")
     */
    private $activitesequencetheoriques;

    /**
     * @ORM\ManyToOne(targetEntity=Categoriesequence::class, inversedBy="sequencetheoriques")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("sequence:lecture")
     */
    private $idcategoriesequence;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=true)
     * @Groups("sequence:lecture")
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("sequence:lecture")
     */
    private $partage;

    public function __construct()
    {
        $this->activitesequencetheoriques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|Activitesequencetheorique[]
     */
    public function getActivitesequencetheoriques(): Collection
    {
        return $this->activitesequencetheoriques;
    }

    public function addActivitesequencetheorique(Activitesequencetheorique $activitesequencetheorique): self
    {
        if (!$this->activitesequencetheoriques->contains($activitesequencetheorique)) {
            $this->activitesequencetheoriques[] = $activitesequencetheorique;
            $activitesequencetheorique->setIdsequencetheorique($this);
        }

        return $this;
    }

    public function removeActivitesequencetheorique(Activitesequencetheorique $activitesequencetheorique): self
    {
        if ($this->activitesequencetheoriques->removeElement($activitesequencetheorique)) {
            // set the owning side to null (unless already changed)
            if ($activitesequencetheorique->getIdsequencetheorique() === $this) {
                $activitesequencetheorique->setIdsequencetheorique(null);
            }
        }

        return $this;
    }

    public function getIdcategoriesequence(): ?Categoriesequence
    {
        return $this->idcategoriesequence;
    }

    public function setIdcategoriesequence(?Categoriesequence $idcategoriesequence): self
    {
        $this->idcategoriesequence = $idcategoriesequence;

        return $this;
    }

    public function getProprietaire(): ?Utilisateur
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Utilisateur $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getPartage(): ?bool
    {
        return $this->partage;
    }

    public function setPartage(?bool $partage): self
    {
        $this->partage = $partage;

        return $this;
    }


}
