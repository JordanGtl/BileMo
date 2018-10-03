<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @UniqueEntity(fields={"name"}, message="Le produit que vous souhaitez ajouter existe déjà")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=200)
     * @Assert\NotBlank(message="Vous devez renseigner un nom pour ajouter/editer un produit")
     */
    // you must fill the name for add/edit the product
    private $name;

    /**
     * @ORM\Column(type="integer")
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
     * @Assert\NotNull
     * @Assert\Range(
     *     min = 0,
     *     minMessage="le DAS ne peut pas être négatif"
     * )
     */
    // the DAS cannot be negative
    private $das;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull
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
