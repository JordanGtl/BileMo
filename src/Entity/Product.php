<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations=
 *     {
 *          "getdetail"={"method"="GET", "path"="products/{id}", "groups"={"list"}, "normalization_context"={"groups"={"get"}}, "swagger_context"={"summary"="Retrieves product details by id."}}
 *     },
 *     collectionOperations=
 *     {
 *          "getlist"={"method"="GET", "path"="products", "groups"={"list"}, "normalization_context"={"groups"={"list"}}}
 *     }
 *     )
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @UniqueEntity(fields={"name"}, message="Le produit que vous souhaitez ajouter existe déjà")
 */
class Product
{
    /**
     * @ORM\Id()
     * @Assert\Uuid
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=200)
     * @Groups({"list", "get"})
     * @Assert\NotBlank(message="Vous devez renseigner un nom pour ajouter/editer un produit")
     */
    // you must fill the name for add/edit the product
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "get"})
     * @Assert\NotNull(message="Vous devez renseigner un prix pour ajouter/editer un produit")
     * @Assert\Range(
     *     min = 0,
     *     minMessage="Le prix ne peut pas être négatif"
     * )
     */
    // you must fill the price for add/edit the product
    private $price;

    /**
     * @ORM\Column(type="float")
     * @Groups({"get"})
     * @Assert\NotNull()
     * @Assert\Range(
     *     min = 0,
     *     minMessage="le DAS ne peut pas être négatif"
     * )
     */
    // the DAS cannot be negative
    private $das;

    /**
     * @ORM\Column(type="float")
     * @Groups({"get"})
     * @Assert\NotNull(groups={"b"})
     * @Assert\Range(
     *     min = 0,
     *     minMessage="La taille de l'écran ne peut pas être négatif"
     * )
     */
    // The screen size cannot be negative
    private $screenSize;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDas(): ?float
    {
        return $this->das;
    }

    public function setDas(float $das): self
    {
        $this->das = $das;

        return $this;
    }

    public function getScreenSize(): ?float
    {
        return $this->screenSize;
    }

    public function setScreenSize(float $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }
}
