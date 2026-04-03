<?php

namespace App\Entity;

use App\Repository\DqlSubjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DqlSubjectRepository::class)]
class DqlSubject extends Subject
{
    #[ORM\Column]
    private ?bool $hasJoins = null;

    #[ORM\Column]
    private ?bool $hasSubqueries = null;

    #[ORM\Column]
    private ?bool $hasAggregations = null;

    #[ORM\Column]
    private ?bool $hasQueryBuilder = null;


    public function hasJoins(): ?bool
    {
        return $this->hasJoins;
    }

    public function setHasJoins(bool $hasJoins): static
    {
        $this->hasJoins = $hasJoins;

        return $this;
    }

    public function hasSubqueries(): ?bool
    {
        return $this->hasSubqueries;
    }

    public function setHasSubqueries(bool $hasSubqueries): static
    {
        $this->hasSubqueries = $hasSubqueries;

        return $this;
    }

    public function hasAggregations(): ?bool
    {
        return $this->hasAggregations;
    }

    public function setHasAggregations(bool $hasAggregations): static
    {
        $this->hasAggregations = $hasAggregations;

        return $this;
    }

    public function hasQueryBuilder(): ?bool
    {
        return $this->hasQueryBuilder;
    }

    public function setHasQueryBuilder(bool $hasQueryBuilder): static
    {
        $this->hasQueryBuilder = $hasQueryBuilder;

        return $this;
    }
}
