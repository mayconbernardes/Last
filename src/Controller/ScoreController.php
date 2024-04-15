<?php

namespace App\Controller;

use App\Entity\Score;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    private ScoreRepository $scoreRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ScoreRepository $scoreRepository, EntityManagerInterface $entityManager)
    {
        $this->scoreRepository = $scoreRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/scores', name: 'app_scores_for_user', methods: ['GET'])]
    public function scoresForUser(): Response
    {
        $user = $this->getUser();
        $scores = $this->scoreRepository->findBy(['user' => $user]);

        return $this->render('score/user_scores.html.twig', [
            'scores' => $scores,
        ]);
    }

    #[Route('/submit-form', name: 'submit_form')]
    public function submitForm(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Retrieve the quiz ID from the form submission
        $quizId = $request->request->get('quiz_id');
        // Retrieve the score value from the form submission
        $scoreValue = $request->request->get('score');

        // Create a new Score entity and persist it
        $score = new Score();
        $score->setUser($user); // Associate the score with the current user

        // Retrieve the quiz object based on the ID
        $quiz = $this->entityManager->getRepository(\App\Entity\Quiz::class)->find($quizId);
        if (!$quiz) {
            // Handle the case when the quiz is not found
            // For example, redirect back to the form with an error message
        }

        $score->setQuiz($quiz); // Set the quiz associated with the score
        $score->setScore($scoreValue); // Set the score value
        $score->setDateCompleted(new \DateTime()); // Set the completion date

        $this->entityManager->persist($score);
        $this->entityManager->flush();

        // Redirect to the user_scores route
        return $this->redirectToRoute('app_scores_for_user');
    }
}
