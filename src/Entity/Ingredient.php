<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string' , length: 255)]
    #[Assert\Length(min:2, max: 50)]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column(type: 'float')]
    #[Assert\Positive()]
    #[Assert\LessThan(200)]
    private ?float $price = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private array $createdAt;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): array
    {
        return $this->createdAt;
    }

    public function setCreatedAt(array $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
