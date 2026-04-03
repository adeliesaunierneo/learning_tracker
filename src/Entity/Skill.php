<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subject $Subject = null;

    #[ORM\Column]
    private ?int $sortOrder = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Exercise>
     */
    #[ORM\ManyToMany(targetEntity: Exercise::class, inversedBy: 'skills')]
    private Collection $exercises;

    /**
     * @var Collection<int, SkillValidation>
     */
    #[ORM\OneToMany(targetEntity: SkillValidation::class, mappedBy: 'Skill', orphanRemoval: true)]
    private Collection $skillValidations;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
        $this->skillValidations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->Subject;
    }

    public function setSubject(?Subject $Subject): static
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): static
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): static
    {
        $this->exercises->removeElement($exercise);

        return $this;
    }

    /**
     * @return Collection<int, SkillValidation>
     */
    public function getSkillValidations(): Collection
    {
        return $this->skillValidations;
    }

    public function addSkillValidation(SkillValidation $skillValidation): static
    {
        if (!$this->skillValidations->contains($skillValidation)) {
            $this->skillValidations->add($skillValidation);
            $skillValidation->setSkill($this);
        }

        return $this;
    }

    public function removeSkillValidation(SkillValidation $skillValidation): static
    {
        if ($this->skillValidations->removeElement($skillValidation)) {
            // set the owning side to null (unless already changed)
            if ($skillValidation->getSkill() === $this) {
                $skillValidation->setSkill(null);
            }
        }

        return $this;
    }
}
