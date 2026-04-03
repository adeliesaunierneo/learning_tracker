<?php

namespace App\Entity;

use App\Repository\SymfonySubjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SymfonySubjectRepository::class)]
class SymfonySubject extends Subject
{

    #[ORM\Column(length: 10)]
    private ?string $symfonyVersion = null;

    #[ORM\Column]
    private ?bool $hasRouting = null;

    #[ORM\Column]
    private ?bool $hasService = null;

    #[ORM\Column]
    private ?bool $hasFormBuilder = null;

    public function getSymfonyVersion(): ?string
    {
        return $this->symfonyVersion;
    }

    public function setSymfonyVersion(string $symfonyVersion): static
    {
        $this->symfonyVersion = $symfonyVersion;

        return $this;
    }

    public function hasRouting(): ?bool
    {
        return $this->hasRouting;
    }

    public function setHasRouting(bool $hasRouting): static
    {
        $this->hasRouting = $hasRouting;

        return $this;
    }

    public function hasService(): ?bool
    {
        return $this->hasService;
    }

    public function setHasService(bool $hasService): static
    {
        $this->hasService = $hasService;

        return $this;
    }

    public function hasFormBuilder(): ?bool
    {
        return $this->hasFormBuilder;
    }

    public function setHasFormBuilder(bool $hasFormBuilder): static
    {
        $this->hasFormBuilder = $hasFormBuilder;

        return $this;
    }
}
