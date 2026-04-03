<?php

namespace App\Entity;

use App\Repository\PostgresqlSubjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostgresqlSubjectRepository::class)]
class PostgresqlSubject extends Subject
{

    #[ORM\Column(length: 10)]
    private ?string $pgVersion = null;

    #[ORM\Column]
    private ?bool $hasJsonb = null;

    #[ORM\Column]
    private ?bool $hasTransactions = null;

    #[ORM\Column]
    private ?bool $hasIndexing = null;

    #[ORM\Column]
    private ?bool $hasWindowFunctions = null;


    public function getPgVersion(): ?string
    {
        return $this->pgVersion;
    }

    public function setPgVersion(string $pgVersion): static
    {
        $this->pgVersion = $pgVersion;

        return $this;
    }

    public function hasJsonb(): ?bool
    {
        return $this->hasJsonb;
    }

    public function setHasJsonb(bool $hasJsonb): static
    {
        $this->hasJsonb = $hasJsonb;

        return $this;
    }

    public function hasTransactions(): ?bool
    {
        return $this->hasTransactions;
    }

    public function setHasTransactions(bool $hasTransactions): static
    {
        $this->hasTransactions = $hasTransactions;

        return $this;
    }

    public function hasIndexing(): ?bool
    {
        return $this->hasIndexing;
    }

    public function setHasIndexing(bool $hasIndexing): static
    {
        $this->hasIndexing = $hasIndexing;

        return $this;
    }

    public function hasWindowFunctions(): ?bool
    {
        return $this->hasWindowFunctions;
    }

    public function setHasWindowFunctions(bool $hasWindowFunctions): static
    {
        $this->hasWindowFunctions = $hasWindowFunctions;

        return $this;
    }
}
