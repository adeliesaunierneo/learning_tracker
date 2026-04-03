<?php

namespace App\DataFixtures;

use App\Entity\PhpSubject;
use App\Entity\SymfonySubject;
use App\Entity\PostgresqlSubject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $php = new PhpSubject();
        $php->setTitle('PHP');
        $php->setSlug('php');
        $php->setDescription('Les bases du langage PHP côté serveur');
        $php->setPhpVersion('8.4');
        $php->setHasOop(false);
        $php->setHasFunctions(false);
        $php->setHasFileHandling(false);
        $php->setCreatedAt(new \DateTimeImmutable());
        $php->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($php);
        $this->addReference('subject-php', $php);

        $symfony = new SymfonySubject();
        $symfony->setTitle('Symfony');
        $symfony->setSlug('symfony');
        $symfony->setDescription('Le framework PHP Symfony 8');
        $symfony->setSymfonyVersion('8.0');
        $symfony->setHasRouting(false);
        $symfony->setHasService(false);
        $symfony->setHasFormBuilder(false);
        $symfony->setCreatedAt(new \DateTimeImmutable());
        $symfony->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($symfony);
        $this->addReference('subject-symfony', $symfony);

        $pg = new PostgresqlSubject();
        $pg->setTitle('PostgreSQL');
        $pg->setSlug('postgresql');
        $pg->setDescription('La base de données relationnelle PostgreSQL');
        $pg->setPgVersion('16');
        $pg->setHasJsonb(false);
        $pg->setHasTransactions(false);
        $pg->setHasIndexing(false);
        $pg->setHasWindowFunctions(false);
        $pg->setCreatedAt(new \DateTimeImmutable());
        $pg->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($pg);
        $this->addReference('subject-postgresql', $pg);

        $manager->flush();
    }
}
