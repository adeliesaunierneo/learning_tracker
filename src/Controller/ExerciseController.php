<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\ExerciseAttemptType;
use App\Repository\ExerciseRepository;
use App\Repository\ExerciseQuestionRepository;
use App\Service\ExerciseAttemptService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exercises')]
class ExerciseController extends AbstractController
{
    public function __construct(
        private readonly ExerciseAttemptService $attemptService,
    ) {}

    #[Route('', name: 'exercise_index', methods: ['GET'])]
    public function index(ExerciseRepository $repo): Response
    {
        return $this->render('exercise/index.html.twig', [
            'exercises' => $repo->findAllWithSubjectAndQuestionCount(),
        ]);
    }

    #[Route('/{id}', name: 'exercise_show', methods: ['GET'])]
    public function show(Exercise $exercise): Response
    {
        return $this->redirectToRoute('exercise_question', [
            'id'       => $exercise->getId(),
            'position' => 1,
        ]);
    }

    #[Route('/{id}/question/{position}', name: 'exercise_question', methods: ['GET', 'POST'])]
    public function question(
        Exercise $exercise,
        int $position,
        Request $request,
        ExerciseQuestionRepository $questionRepo,
    ): Response {
        $questions = $questionRepo->findByExerciseOrdered($exercise);
        $total     = count($questions);

        if ($position < 1 || $position > $total) {
            throw $this->createNotFoundException('Question introuvable.');
        }

        $currentQuestion = $questions[$position - 1];

        // Le service gère la logique de récupération/création
        $attempt = $this->attemptService->getOrCreateAttempt($currentQuestion);

        // Le FormType gère la structure et la validation
        $form = $this->createForm(ExerciseAttemptType::class, $attempt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le service gère la persistance
            $this->attemptService->saveAttempt($attempt);
            $this->addFlash('success', 'Réponse sauvegardée !');

            // Navigation automatique vers la question suivante
            $nextPosition = $position < $total ? $position + 1 : $position;

            return $this->redirectToRoute('exercise_question', [
                'id'       => $exercise->getId(),
                'position' => $nextPosition,
            ]);
        }

        return $this->render('exercise/question.html.twig', [
            'exercise' => $exercise,
            'question' => $currentQuestion,
            'form'     => $form,
            'position' => $position,
            'total'    => $total,
            'hasPrev'  => $position > 1,
            'hasNext'  => $position < $total,
        ]);
    }

    #[Route('/{id}/review', name: 'exercise_review', methods: ['GET'])]
    public function review(
        Exercise $exercise,
        ExerciseQuestionRepository $questionRepo,
    ): Response {
        $questions   = $questionRepo->findByExerciseOrdered($exercise);
        $progression = $this->attemptService->getProgressionForExercise($questions);

        return $this->render('exercise/review.html.twig', [
            'exercise'   => $exercise,
            'questions'  => $questions,
            'progression' => $progression,
        ]);
    }
}
