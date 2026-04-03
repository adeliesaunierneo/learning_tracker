<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use App\Entity\ExerciseQuestion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciseQuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [ExerciseFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $questions = [

            // ── Questions PostgreSQL ──────────────────────────────────────────
            'exercise-postgresql' => [
                [
                    'text'       => 'Affiche toutes les matières avec leur titre, leur slug et leur type, triées par titre alphabétique.',
                    'hint'       => 'Utilise SELECT et ORDER BY sur la table subject.',
                    'correction' =>
                        "SELECT title, slug, type\n" .
                        "FROM subject\n" .
                        "ORDER BY title ASC;",
                    'order'      => 1,
                ],
                [
                    'text'       => 'Affiche toutes les compétences de la matière PHP avec leur nom et leur sort_order, triées par sort_order croissant.',
                    'hint'       => 'Il faut joindre skill et subject via subject_id. Filtre sur le slug "php".',
                    'correction' =>
                        "SELECT s.name, s.sort_order\n" .
                        "FROM skill s\n" .
                        "INNER JOIN subject sub ON sub.id = s.subject_id\n" .
                        "WHERE sub.slug = 'php'\n" .
                        "ORDER BY s.sort_order ASC;",
                    'order'      => 2,
                ],
                [
                    'text'       => 'Affiche le titre de la matière PHP ET ses colonnes spécifiques (php_version, has_oop, has_functions, has_file_handling) en une seule requête. Pourquoi faut-il joindre deux tables ?',
                    'hint'       => 'La table php_subject est liée à subject via ps.id = sub.id — c\'est l\'héritage JOINED de Doctrine.',
                    'correction' =>
                        "SELECT sub.title, sub.slug,\n" .
                        "       ps.php_version, ps.has_oop,\n" .
                        "       ps.has_functions, ps.has_file_handling\n" .
                        "FROM subject sub\n" .
                        "INNER JOIN php_subject ps ON ps.id = sub.id\n" .
                        "WHERE sub.type = 'php';",
                    'order'      => 3,
                ],
                [
                    'text'       => 'Affiche chaque exercice avec la liste des compétences qu\'il couvre. Un exercice peut couvrir plusieurs compétences — une ligne par compétence.',
                    'hint'       => 'La relation Exercise ↔ Skill est ManyToMany via skill_exercise. Il faut deux JOIN : exercise → skill_exercise → skill.',
                    'correction' =>
                        "SELECT e.title AS exercice,\n" .
                        "       e.difficulty,\n" .
                        "       s.name AS competence_couverte\n" .
                        "FROM exercise e\n" .
                        "INNER JOIN skill_exercise se ON se.exercise_id = e.id\n" .
                        "INNER JOIN skill s           ON s.id = se.skill_id\n" .
                        "ORDER BY e.title ASC, s.sort_order ASC;",
                    'order'      => 4,
                ],
                [
                    'text'       => 'Affiche toutes les matières avec le nombre de compétences pour chacune (0 si aucune). Pourquoi LEFT JOIN et pas INNER JOIN ici ?',
                    'hint'       => 'LEFT JOIN garantit que toutes les matières apparaissent, même sans compétences. COUNT(s.id) retourne 0 si aucune ligne.',
                    'correction' =>
                        "SELECT sub.title AS matiere,\n" .
                        "       COUNT(s.id) AS nb_competences\n" .
                        "FROM subject sub\n" .
                        "LEFT JOIN skill s ON s.subject_id = sub.id\n" .
                        "GROUP BY sub.id, sub.title\n" .
                        "ORDER BY nb_competences DESC;",
                    'order'      => 5,
                ],
                [
                    'text'       => 'Affiche pour chaque matière : le nombre total de compétences, le nombre validées (done), en cours et à faire, ainsi que le pourcentage de progression.',
                    'hint'       => 'Utilise CASE WHEN sv.status = \'done\' THEN 1 ELSE 0 END dans un SUM(). Protège la division avec NULLIF(COUNT(s.id), 0).',
                    'correction' =>
                        "SELECT sub.title AS matiere,\n" .
                        "    COUNT(s.id) AS total,\n" .
                        "    SUM(CASE WHEN sv.status = 'done'        THEN 1 ELSE 0 END) AS validees,\n" .
                        "    SUM(CASE WHEN sv.status = 'in_progress' THEN 1 ELSE 0 END) AS en_cours,\n" .
                        "    SUM(CASE WHEN sv.status = 'todo'        THEN 1 ELSE 0 END) AS a_faire,\n" .
                        "    ROUND(\n" .
                        "        100.0 * SUM(CASE WHEN sv.status = 'done' THEN 1 ELSE 0 END)\n" .
                        "        / NULLIF(COUNT(s.id), 0),\n" .
                        "    1) AS progression_pct\n" .
                        "FROM subject sub\n" .
                        "LEFT JOIN skill s             ON s.subject_id = sub.id\n" .
                        "LEFT JOIN skill_validation sv ON sv.skill_id  = s.id\n" .
                        "GROUP BY sub.id, sub.title\n" .
                        "ORDER BY progression_pct DESC NULLS LAST;",
                    'order'      => 6,
                ],
            ],

            // ── Questions DQL ─────────────────────────────────────────────────
            'exercise-symfony' => [
                [
                    'text'       => 'Dans SkillRepository, crée la méthode findAllOrderedBySortOrder(): array qui retourne toutes les compétences triées par sort_order avec le QueryBuilder.',
                    'hint'       => 'Utilise $this->createQueryBuilder(\'s\') puis ->orderBy(\'s.sortOrder\', \'ASC\').',
                    'correction' =>
                        "public function findAllOrderedBySortOrder(): array\n" .
                        "{\n" .
                        "    return \$this->createQueryBuilder('s')\n" .
                        "        ->orderBy('s.sortOrder', 'ASC')\n" .
                        "        ->getQuery()\n" .
                        "        ->getResult();\n" .
                        "}",
                    'order'      => 1,
                ],
                [
                    'text'       => 'Crée la méthode findBySubjectSlug(string $slug): array dans SkillRepository. Elle retourne les compétences d\'une matière filtrée par son slug.',
                    'hint'       => 'Utilise ->join(\'s.subject\', \'sub\') puis ->where(\'sub.slug = :slug\') et ->setParameter(\'slug\', $slug).',
                    'correction' =>
                        "public function findBySubjectSlug(string \$slug): array\n" .
                        "{\n" .
                        "    return \$this->createQueryBuilder('s')\n" .
                        "        ->join('s.subject', 'sub')\n" .
                        "        ->where('sub.slug = :slug')\n" .
                        "        ->setParameter('slug', \$slug)\n" .
                        "        ->orderBy('s.sortOrder', 'ASC')\n" .
                        "        ->getQuery()\n" .
                        "        ->getResult();\n" .
                        "}",
                    'order'      => 2,
                ],
                [
                    'text'       => 'Crée findAllWithSubject(): array dans SkillRepository. Elle doit charger les compétences ET leur matière en une seule requête. Quelle est la différence entre JOIN et JOIN avec addSelect ?',
                    'hint'       => 'Utilise ->addSelect(\'sub\') avec ->join(\'s.subject\', \'sub\'). Sans addSelect, Doctrine fera une requête par compétence pour charger la matière — c\'est le problème N+1.',
                    'correction' =>
                        "public function findAllWithSubject(): array\n" .
                        "{\n" .
                        "    return \$this->createQueryBuilder('s')\n" .
                        "        ->addSelect('sub')\n" .
                        "        ->join('s.subject', 'sub')\n" .
                        "        ->orderBy('sub.title', 'ASC')\n" .
                        "        ->addOrderBy('s.sortOrder', 'ASC')\n" .
                        "        ->getQuery()\n" .
                        "        ->getResult();\n" .
                        "}",
                    'order'      => 3,
                ],
                [
                    'text'       => 'Crée getProgressionBySubject(): array dans SkillRepository. Elle reproduit le tableau de bord en DQL avec COUNT et SUM(CASE WHEN ...). Quelle méthode utiliser à la place de getResult() pour les agrégations ?',
                    'hint'       => 'Les LEFT JOIN entre entités non directement liées utilisent WITH en DQL : LEFT JOIN App\Entity\Skill s WITH s.subject = sub. Utilise ->getArrayResult() pour récupérer des tableaux plutôt que des objets.',
                    'correction' =>
                        "public function getProgressionBySubject(): array\n" .
                        "{\n" .
                        "    return \$this->getEntityManager()\n" .
                        "        ->createQuery(\n" .
                        "            'SELECT sub.title AS matiere,' .\n" .
                        "            ' COUNT(s.id) AS total,' .\n" .
                        "            ' SUM(CASE WHEN sv.status = \\'done\\' THEN 1 ELSE 0 END) AS validees' .\n" .
                        "            ' FROM App\\\\Entity\\\\Subject sub' .\n" .
                        "            ' LEFT JOIN App\\\\Entity\\\\Skill s WITH s.subject = sub' .\n" .
                        "            ' LEFT JOIN App\\\\Entity\\\\SkillValidation sv WITH sv.skill = s' .\n" .
                        "            ' GROUP BY sub.id, sub.title' .\n" .
                        "            ' ORDER BY validees DESC'\n" .
                        "        )\n" .
                        "        ->getArrayResult();\n" .
                        "}",
                    'order'      => 4,
                ],
            ],
        ];

        foreach ($questions as $exerciseRef => $questionList) {
            $exercise = $this->getReference($exerciseRef, Exercise::class);
            foreach ($questionList as $data) {
                $q = new ExerciseQuestion();
                $q->setExercise($exercise);
                $q->setQuestionText($data['text']);
                $q->setCorrection($data['correction']);
                $q->setHint($data['hint']);
                $q->setSortOrder($data['order']);
                $manager->persist($q);
            }
        }

        $manager->flush();
    }
}
