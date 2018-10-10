<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(collectionOperations={
 *     "getlist"={"method"="GET", "path"="clients", "groups"={"list"}, "normalization_context"={"groups"={"list"}}},
 *     "getdetail"={"method"="GET", "path"="clients/{id}", "groups"={"list"}, "normalization_context"={"groups"={"get"}}},
 *      }
 *     )
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"list", "get"})
     * @Assert\NotBlank(message="Le prénom du client ne peut être vide")
     */
    // The firstname of customer cannot be empty
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"list", "get"})
     * @Assert\NotBlank(message="Le nom du client ne peut être vide")
     */
    // The name of customer cannot be empty
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
