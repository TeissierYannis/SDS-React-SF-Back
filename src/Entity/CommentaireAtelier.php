<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaireAtelierRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Table(name="commentaire_atelier")
 * @ORM\Entity
 *
 * @ApiResource(itemOperations={
 *     "get",
 *     "delete"={"security"="is_granted('ROLE_ADMIN') or object.getProprietaire() == user"},
 *     "customer_action"={
 *          "method"="post",
 *          "security"="is_granted('ROLE_USER')",
 *          "route_name"="ajouterCommentaire_route"
 *      }
 * })
 */
class CommentaireAtelier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("atelier:lecture")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups("atelier:lecture")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Groups("atelier:lecture")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class )
     * @ORM\JoinColumn(nullable=true)
     * @Groups("atelier:lecture")
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("atelier:lecture")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Atelier::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $atelier;

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

    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    public function setAtelier(?Atelier $atelier): self
    {
        $this->atelier = $atelier;

        return $this;
    }
}
