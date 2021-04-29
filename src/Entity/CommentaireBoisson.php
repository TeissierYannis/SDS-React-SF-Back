<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaireBoissonRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Table(name="commentaire_boisson")
 * @ORM\Entity
 *
 * @ApiResource(itemOperations={
 *     "get",
 *     "delete"={"security"="is_granted('ROLE_ADMIN') or object.getProprietaire() == user"},
 *     "customer_action"={
 *          "method"="post",
 *          "security"="is_granted('ROLE_USER')",
 *          "route_name"="ajouterCommentaireBoisson_route"
 *      }
 * })
 */
class CommentaireBoisson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("boisson:lecture")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups("boisson:lecture")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Groups("boisson:lecture")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class )
     * @ORM\JoinColumn(nullable=true)
     * @Groups("boisson:lecture")
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("boisson:lecture")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Boisson::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $boisson;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getBoisson(): ?Atelier
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }
}
