<?php

namespace App\Entity;

use App\Repository\PhpSubjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhpSubjectRepository::class)]
class PhpSubject extends Subject
{

    #[ORM\Column(length: 10)]
    private ?string $phpVersion = null;

    #[ORM\Column]
    private ?bool $hasOop = null;

    #[ORM\Column]
    private ?bool $hasFunctions = null;

    #[ORM\Column]
    private ?bool $hasFileHandling = null;

    public function getPhpVersion(): ?string
    {
        return $this->phpVersion;
    }

    public function setPhpVersion(string $phpVersion): static
    {
        $this->phpVersion = $phpVersion;

        return $this;
    }

    public function hasOop(): ?bool
    {
        return $this->hasOop;
    }

    public function setHasOop(bool $hasOop): static
    {
        $this->hasOop = $hasOop;

        return $this;
    }

    public function hasFunctions(): ?bool
    {
        return $this->hasFunctions;
    }

    public function setHasFunctions(bool $hasFunctions): static
    {
        $this->hasFunctions = $hasFunctions;

        return $this;
    }

    public function hasFileHandling(): ?bool
    {
        return $this->hasFileHandling;
    }

    public function setHasFileHandling(bool $hasFileHandling): static
    {
        $this->hasFileHandling = $hasFileHandling;

        return $this;
    }
}
