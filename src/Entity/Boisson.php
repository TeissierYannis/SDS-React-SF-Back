<?php


namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="boisson")
 * @ORM\Entity()
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"boisson:lecture"}},
 *      itemOperations={
 *         "get",
 *         "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
 *     },
 * )
 */
class Boisson
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups("boisson:lecture")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("boisson:lecture")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("boisson:lecture")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("boisson:lecture")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireBoisson::class, mappedBy="boisson")
     * @Groups("boisson:lecture")
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Collection|CommentaireBoisson[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(CommentaireBoisson $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setBoisson($this);
        }

        return $this;
    }

    public function removeCommentaire(CommentaireBoisson $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getBoisson() === $this) {
                $commentaire->setBoisson(null);
            }
        }

        return $this;
    }
}
