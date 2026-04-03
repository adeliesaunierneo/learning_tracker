<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use App\Entity\PhpSubject;
use App\Entity\SymfonySubject;
use App\Entity\PostgresqlSubject;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [SubjectFixtures::class, SkillFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        // Exercice PHP 1
        $ex1 = new Exercise();
        $ex1->setTitle('Manipulation de tableaux PHP');
        $ex1->setInstructions(
            'À partir du tableau $competences fourni, utiliser array_map, ' .
            'array_filter et array_reduce pour : compter les compétences par statut, ' .
            'calculer la durée totale par matière, obtenir les compétences restantes.'
        );
        $ex1->setDifficulty(2);
        $ex1->setEstimatedMinutes(45);
        $ex1->setExpectedOutput('Un tableau associatif [statut => nombre]');
        $ex1->setSubject($this->getReference('subject-php', PhpSubject::class));
        $ex1->setCreatedAt(new \DateTimeImmutable());
        $ex1->addSkill($this->getReference('skill-subject-php-0', Skill::class));
        $ex1->addSkill($this->getReference('skill-subject-php-4', Skill::class));
        $manager->persist($ex1);
        $this->addReference('exercise-php', $ex1);
        // Exercice PHP 2
        $ex2 = new Exercise();
        $ex2->setTitle('Parser un fichier XSD et valider un XML');
        $ex2->setInstructions(
            'Créer un fichier XSD décrivant la structure des compétences. ' .
            'Générer un XML représentant les matières et leurs compétences. ' .
            'Valider le XML contre le XSD avec DOMDocument.'
        );
        $ex2->setDifficulty(4);
        $ex2->setEstimatedMinutes(90);
        $ex2->setSubject($this->getReference('subject-php', PhpSubject::class));
        $ex2->setCreatedAt(new \DateTimeImmutable());
        $ex2->addSkill($this->getReference('skill-subject-php-2', Skill::class));
        $ex2->addSkill($this->getReference('skill-subject-php-3', Skill::class));
        $manager->persist($ex2);
        $this->addReference('exercise-php-2', $ex2);

        // Exercice Symfony 1
        $ex3 = new Exercise();
        $ex3->setTitle('Créer le SubjectController avec ses routes');
        $ex3->setInstructions(
            'Créer un contrôleur SubjectController avec 3 routes : ' .
            'GET /subjects (liste), GET /subjects/{slug} (détail), ' .
            'GET /subjects/{slug}/skills (compétences d\'une matière). ' .
            'Utiliser le ParamConverter pour convertir le slug en entité.'
        );
        $ex3->setDifficulty(2);
        $ex3->setEstimatedMinutes(60);
        $ex3->setSubject($this->getReference('subject-symfony', SymfonySubject::class));
        $ex3->setCreatedAt(new \DateTimeImmutable());
        $ex3->addSkill($this->getReference('skill-subject-symfony-0', Skill::class));
        $manager->persist($ex3);
        $this->addReference('exercise-symfony', $ex3);

        // Exercice PostgreSQL 1
        $ex4 = new Exercise();
        $ex4->setTitle('Requête de tableau de bord de progression');
        $ex4->setInstructions(
            'Écrire une requête SQL qui retourne pour chaque matière : ' .
            'le nombre total de compétences, le nombre validées (done), ' .
            'et le pourcentage de progression. Utiliser une CTE pour structurer la requête.'
        );
        $ex4->setDifficulty(3);
        $ex4->setEstimatedMinutes(45);
        $ex4->setSubject($this->getReference('subject-postgresql', PostgresqlSubject::class));
        $ex4->setCreatedAt(new \DateTimeImmutable());
        $ex4->addSkill($this->getReference('skill-subject-postgresql-0', Skill::class));
        $ex4->addSkill($this->getReference('skill-subject-postgresql-1', Skill::class));
        $manager->persist($ex4);
        $this->addReference('exercise-postgresql', $ex4);

        $manager->flush();
    }
}
