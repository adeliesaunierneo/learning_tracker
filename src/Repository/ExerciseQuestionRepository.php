<?php

namespace App\Repository;

use App\Entity\Exercise;
use App\Entity\ExerciseQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExerciseQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciseQuestion::class);
    }

    public function findByExerciseOrdered(Exercise $exercise): array
    {
        return $this->createQueryBuilder('q')
                    ->where('q.exercise = :exercise')
                    ->setParameter('exercise', $exercise)
                    ->orderBy('q.sortOrder', 'ASC')
                    ->getQuery()
                    ->getResult();
    }
}
