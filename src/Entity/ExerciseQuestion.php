<?php

namespace App\Entity;

use App\Repository\ExerciseQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseQuestionRepository::class)]
class ExerciseQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'exerciseQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercise $exercise = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $questionText = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $correction = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $hint = null;

    #[ORM\Column]
    private ?int $sortOrder = null;

    /**
     * @var Collection<int, ExerciseAttempt>
     */
    #[ORM\OneToMany(targetEntity: ExerciseAttempt::class, mappedBy: 'question', orphanRemoval: true)]
    private Collection $exerciseAttempts;

    public function __construct()
    {
        $this->exerciseAttempts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): static
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): static
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getCorrection(): ?string
    {
        return $this->correction;
    }

    public function setCorrection(string $correction): static
    {
        $this->correction = $correction;

        return $this;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function setHint(string $hint): static
    {
        $this->hint = $hint;

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

    /**
     * @return Collection<int, ExerciseAttempt>
     */
    public function getExerciseAttempts(): Collection
    {
        return $this->exerciseAttempts;
    }

    public function addExerciseAttempt(ExerciseAttempt $exerciseAttempt): static
    {
        if (!$this->exerciseAttempts->contains($exerciseAttempt)) {
            $this->exerciseAttempts->add($exerciseAttempt);
            $exerciseAttempt->setQuestion($this);
        }

        return $this;
    }

    public function removeExerciseAttempt(ExerciseAttempt $exerciseAttempt): static
    {
        if ($this->exerciseAttempts->removeElement($exerciseAttempt)) {
            // set the owning side to null (unless already changed)
            if ($exerciseAttempt->getQuestion() === $this) {
                $exerciseAttempt->setQuestion(null);
            }
        }

        return $this;
    }
}
