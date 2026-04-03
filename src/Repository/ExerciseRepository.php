<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    public function findAllWithSubjectAndQuestionCount(): array
    {
        // Récupère les exercices avec leur subject — sans COUNT pour éviter le GROUP BY sur l'héritage
        $exercises = $this->createQueryBuilder('e')
                          ->addSelect('sub')
                          ->join('e.subject', 'sub')
                          ->orderBy('sub.title', 'ASC')
                          ->addOrderBy('e.difficulty', 'ASC')
                          ->getQuery()
                          ->getResult();

        return $exercises;
    }
}
