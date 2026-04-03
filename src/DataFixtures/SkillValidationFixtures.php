<?php

namespace App\DataFixtures;

use App\Entity\SkillValidation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkillValidationFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [SkillFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $validations = [
            // PHP — quelques compétences avec statuts variés
            ['skill-subject-php-0', 'done',        '2026-03-01', 'Très bien maîtrisé !', 'Je me sens à l\'aise avec array_map'],
            ['skill-subject-php-1', 'in_progress',  null,         'Continuer sur les interfaces', null],
            ['skill-subject-php-2', 'todo',          null,         null,                   null],
            ['skill-subject-php-3', 'todo',          null,         null,                   null],
            ['skill-subject-php-4', 'done',          '2026-03-10', 'Bonne compréhension', 'Les closures c\'est clair'],
            // Symfony
            ['skill-subject-symfony-0', 'done',      '2026-03-15', 'Routes bien comprises', null],
            ['skill-subject-symfony-1', 'in_progress', null,       'Revoir l\'autowiring',  null],
            ['skill-subject-symfony-2', 'todo',        null,        null,                   null],
            ['skill-subject-symfony-3', 'todo',        null,        null,                   null],
            // PostgreSQL
            ['skill-subject-postgresql-0', 'done',   '2026-03-20', 'Les JOIN sont clairs', 'J\'ai bien compris INNER vs LEFT'],
            ['skill-subject-postgresql-1', 'in_progress', null,    null,                   null],
            ['skill-subject-postgresql-2', 'todo',    null,         null,                   null],
            ['skill-subject-postgresql-3', 'todo',    null,         null,                   null],
        ];

        foreach ($validations as [$skillRef, $status, $validatedAt, $mentorNote, $selfNote]) {
            $sv = new SkillValidation();
            $sv->setSkill($this->getReference($skillRef, \App\Entity\Skill::class));
            $sv->setStatus($status);
            $sv->setValidatedAt($validatedAt ? new \DateTimeImmutable($validatedAt) : null);
            $sv->setMentorNote($mentorNote);
            $sv->setSelfNote($selfNote);
            $manager->persist($sv);
        }

        $manager->flush();
    }
}
