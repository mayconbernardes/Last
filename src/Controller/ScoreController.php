<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        // Retrieve the User entity by its ID
        $user = $this->getUser();
        // Retrieve scores for the specified user from the ScoreRepository
        $scores = $user->getScores();

        // Render the Twig template to display scores for the user
        return $this->render('score/user_scores.html.twig', [
            'scores' => $scores,
        ]);
    }

    #[Route('/submit-form', name: 'submit_form')]
    public function submitForm(): Response
    {
       // Check if the user is authenticated
    $user = $this->getUser();
    if (!$user || !$user instanceof User || !$user->getId()) {
        // Log or dump information for debugging
        // dump($user);

        // Handle case when user is not authenticated or ID is not available (e.g., redirect to login page)
        return $this->redirectToRoute('app_login'); // Adjust route name as needed
    }

    // Redirect to the user_scores route
    return $this->redirectToRoute('app_scores_for_user', ['userId' => $user->getId()]);
    }
}