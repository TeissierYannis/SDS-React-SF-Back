<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Categoriesequence
 *
 * @ORM\Table(name="categoriesequence")
 * @ORM\Entity
 */
class Categoriesequence
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("sequence:lecture")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="text", length=65535, nullable=false)
     * @Groups("sequence:lecture")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text", length=65535, nullable=false)
     * @Groups("sequence:lecture")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Sequencetheorique::class, mappedBy="idcategoriesequence", orphanRemoval=true)
     */
    private $sequencetheoriques;

    public function __construct()
    {
        $this->sequencetheoriques = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Sequencetheorique[]
     */
    public function getSequencetheoriques(): Collection
    {
        return $this->sequencetheoriques;
    }

    public function addSequencetheorique(Sequencetheorique $sequencetheorique): self
    {
        if (!$this->sequencetheoriques->contains($sequencetheorique)) {
            $this->sequencetheoriques[] = $sequencetheorique;
            $sequencetheorique->setIdcategoriesequence($this);
        }

        return $this;
    }

    public function removeSequencetheorique(Sequencetheorique $sequencetheorique): self
    {
        if ($this->sequencetheoriques->removeElement($sequencetheorique)) {
            // set the owning side to null (unless already changed)
            if ($sequencetheorique->getIdcategoriesequence() === $this) {
                $sequencetheorique->setIdcategoriesequence(null);
            }
        }

        return $this;
    }


}
