<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\Table(name: 'addresses')]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['address:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'addresses')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['address:read', 'address:write'])]
    private ?string $label = null;

    #[ORM\Column(length: 100)]
    #[Groups(['address:read', 'address:write'])]
    #[Assert\NotBlank]
    private string $firstName;

    #[ORM\Column(length: 100)]
    #[Groups(['address:read', 'address:write'])]
    #[Assert\NotBlank]
    private string $lastName;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read', 'address:write'])]
    #[Assert\NotBlank]
    private string $street;

    #[ORM\Column(length: 100)]
    #[Groups(['address:read', 'address:write'])]
    #[Assert\NotBlank]
    private string $city;

    #[ORM\Column(length: 20)]
    #[Groups(['address:read', 'address:write'])]
    #[Assert\NotBlank]
    private string $postalCode;

    #[ORM\Column(length: 100)]
    #[Groups(['address:read', 'address:write'])]
    #[Assert\NotBlank]
    private string $country;

    #[ORM\Column(options: ['default' => false])]
    #[Groups(['address:read', 'address:write'])]
    private bool $isDefault = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): static
    {
        $this->isDefault = $isDefault;

        return $this;
    }
}
