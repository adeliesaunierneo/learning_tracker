<?php

namespace App\Entity;

use App\Repository\SkillValidationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillValidationRepository::class)]
class SkillValidation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'skillValidations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skill $Skill = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mentorNote = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $selfNote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->Skill;
    }

    public function setSkill(?Skill $Skill): static
    {
        $this->Skill = $Skill;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeImmutable
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(?\DateTimeImmutable $validatedAt): static
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function getMentorNote(): ?string
    {
        return $this->mentorNote;
    }

    public function setMentorNote(?string $mentorNote): static
    {
        $this->mentorNote = $mentorNote;

        return $this;
    }

    public function getSelfNote(): ?string
    {
        return $this->selfNote;
    }

    public function setSelfNote(?string $selfNote): static
    {
        $this->selfNote = $selfNote;

        return $this;
    }

}
