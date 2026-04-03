<?php

namespace App\Service;

use App\Entity\ExerciseAttempt;
use App\Entity\ExerciseQuestion;
use Doctrine\ORM\EntityManagerInterface;

class ExerciseAttemptService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {}

    /**
     * Récupère la tentative existante pour une question,
     * ou crée une nouvelle instance vide.
     */
    public function getOrCreateAttempt(ExerciseQuestion $question): ExerciseAttempt
    {
        $existing = $question->getExerciseAttempts()->first();

        if ($existing instanceof ExerciseAttempt) {
            return $existing;
        }

        $attempt = new ExerciseAttempt();
        $attempt->setQuestion($question);
        $attempt->setAttemptedAt(new \DateTimeImmutable());

        return $attempt;
    }

    /**
     * Sauvegarde la tentative en base.
     */
    public function saveAttempt(ExerciseAttempt $attempt): void
    {
        $attempt->setAttemptedAt(new \DateTimeImmutable());
        $this->em->persist($attempt);
        $this->em->flush();
    }

    /**
     * Calcule le nombre de questions réussies pour un exercice.
     * Retourne ['done' => int, 'total' => int, 'pct' => float]
     */
    public function getProgressionForExercise(array $questions): array
    {
        $total = count($questions);
        $done  = 0;

        foreach ($questions as $question) {
            $attempt = $question->getExerciseAttempts()->first();
            if ($attempt instanceof ExerciseAttempt && $attempt->isCorrect()) {
                $done++;
            }
        }

        return [
            'done'  => $done,
            'total' => $total,
            'pct'   => $total > 0 ? round($done / $total * 100, 1) : 0.0,
        ];
    }
}
