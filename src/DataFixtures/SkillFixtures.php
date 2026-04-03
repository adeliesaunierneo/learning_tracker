<?php

namespace App\DataFixtures;

use App\Entity\DqlSubject;
use App\Entity\PhpSubject;
use App\Entity\SymfonySubject;
use App\Entity\PostgresqlSubject;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [SubjectFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $skills = [
            'subject-php' => [
                'class' => PhpSubject::class,
                'skills' => [
                    ['Maîtriser les tableaux (array_map, filter, reduce)', 1],
                    ['Comprendre la POO : classes, héritage, interfaces', 2],
                    ['Lire et écrire des fichiers (fopen, SplFileObject)', 2],
                    ['Parser un fichier XSD avec DOMDocument', 4],
                    ['Utiliser les closures et fonctions d\'ordre supérieur', 3],
                ],
            ],
            'subject-symfony' => [
                'class' => SymfonySubject::class,
                'skills' => [
                    ['Comprendre le routing et les contrôleurs', 1],
                    ['Créer un service et utiliser l\'injection de dépendances', 2],
                    ['Construire un formulaire avec FormType', 3],
                    ['Utiliser les events et EventSubscriber', 4],
                ],
            ],
            'subject-postgresql' => [
                'class' => PostgresqlSubject::class,
                'skills' => [
                    ['Écrire des SELECT avec JOIN', 1],
                    ['Utiliser GROUP BY et les agrégations', 2],
                    ['Comprendre les index et les performances', 3],
                    ['Utiliser le type JSONB', 4],
                ],
            ],
            'subject-dql' => [
                'class' => DqlSubject::class,
                'skills' => [
                    ['Écrire une query DQL simple', 1],
                    ['Utiliser le QueryBuilder Doctrine', 2],
                    ['Faire des JOIN entre entités', 3],
                    ['Maîtriser les agrégations DQL', 3],
                ],
            ],
        ];

        foreach ($skills as $subjectRef => $data) {
            $subject = $this->getReference($subjectRef, $data['class']);
            foreach ($data['skills'] as $i => [$name, $sortOrder]) {
                $skill = new Skill();
                $skill->setName($name);
                $skill->setSubject($subject);
                $skill->setSortOrder($sortOrder);
                $skill->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($skill);
                $this->addReference('skill-' . $subjectRef . '-' . $i, $skill);
            }
        }

        $manager->flush();
    }
}
