<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity
 * @ORM\Table(name="Utilisateur")
 *
 */
class Utilisateur implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("atelier:lecture","utilisateur:lecture","sequence:lecture")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Groups("utilisateur:lecture", "atelier:lecture","sequence:lecture")
     */
    private $login;

    /**
     * @ORM\Column(type="string" )
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     * @Groups("atelier:lecture","utilisateur:lecture","sequence:lecture")
     */
    private $nomUtilisateur;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     * @Groups("atelier:lecture","utilisateur:lecture","sequence:lecture")
     */
    private $prenomUtilisateur;

    /**
     * @ORM\Column(type="string", unique=true )
     * @Assert\Email()
     * @Groups("atelier:lecture","utilisateur:lecture")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];


    /**
     * Utilisateur constructor.
     */
    public function __construct()
    {
        $this->id = -1;
        $this->login = "";
        $this->nomUtilisateur = "";
        $this->prenomUtilisateur = "";
        $this->email = "";
        $this->password = "";
        $this->roles = "";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getNomUtilisateur(): string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): void
    {
        $this->nomUtilisateur = $nomUtilisateur;
    }

    public function getPrenomUtilisateur(): string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): void
    {
        $this->prenomUtilisateur = $prenomUtilisateur;
    }


    /*
    * Méthode obligatoire pour répondre aux besoins de l'héritage à userInterface
    */
    public function getUserName(): string
    {
        return $this->login;
    }



    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /*
    * Méhtode héritée de UserInterface
    */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /*
    * Méhtode héritée de UserInterface
    */
    public function getRoles(): array
    {
        $roles = $this->roles;

// il est obligatoire d'avoir au moins un rôle si on est authentifié, par convention c'est ROLE_USER
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /*
    * Méhtode héritée de UserInterface
    */
    public function getSalt(): ?string
    {
        return null;
    }

    /*
    * Méhtode héritée de UserInterface
    */
    public function eraseCredentials(): void
    {
    //    $this->password = "";
    //    $this->id = -1 ;
    }

}