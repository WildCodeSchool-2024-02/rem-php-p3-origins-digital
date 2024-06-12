<?php

namespace App\Entity;

use App\Repository\ParamApiRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParamApiRepository::class)]
class ParamApi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $apiName = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateToken = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApiName(): ?string
    {
        return $this->apiName;
    }

    public function setApiName(string $apiName): static
    {
        $this->apiName = $apiName;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getDateToken(): ?\DateTimeInterface
    {
        return $this->dateToken;
    }

    public function setDateToken(\DateTimeInterface $dateToken): static
    {
        $this->dateToken = $dateToken;

        return $this;
    }

}
