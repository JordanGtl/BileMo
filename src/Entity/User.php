<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *     itemOperations=
 *     {
 *          "getdetail"={"method"="GET", "path"="users/{id}", "groups"={"list"}, "normalization_context"={"groups"={"get"}}},
 *          "delete"={"method"="DELETE", "path"="users/{id}", "groups"={"list"}, "normalization_context"={"groups"={"get"}}},
 *     },
 *     collectionOperations=
 *     {
 *          "getlist"={"method"="GET", "path"="users", "groups"={"list"}, "normalization_context"={"groups"={"list"}}},
 *          "create"={"method"="POST", "path"="users", "groups"={"list"}, "normalization_context"={"groups"={"list", "post"}}},
 *     }
 *     )
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups({"list", "get", "post"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"list", "get", "post"})
     * @Assert\NotBlank(message="The firstname of customer cannot be empty")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"list", "get", "post"})
     * @Assert\NotBlank(message="The name of customer cannot be empty")
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="user")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank(message="Adress of customer cannot be empty")
     * @Groups({"get", "post"})
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="The city of customer cannot be empty")
     * @Groups({"get", "post"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="The postal code of customer cannot be empty")
     * @Groups({"get", "post"})
     */
    private $postalCode;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }
}
