<?php

namespace App\Controller;

use App\Entity\Score;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur pour gérer les scores des utilisateurs
class ScoreController extends AbstractController
{
    private ScoreRepository $scoreRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ScoreRepository $scoreRepository, EntityManagerInterface $entityManager)
    {
        $this->scoreRepository = $scoreRepository;
        $this->entityManager = $entityManager;
    }

    // Affiche les scores de l'utilisateur actuel
    #[Route('/scores', name: 'app_scores_for_user', methods: ['GET'])]
    public function scoresForUser(): Response
    {
        $user = $this->getUser();
        $scores = $this->scoreRepository->findBy(['user' => $user]);

        return $this->render('score/user_scores.html.twig', [
            'scores' => $scores,
        ]);
    }

    // Soumet un formulaire de score
    #[Route('/submit-form', name: 'submit_form')]
    public function submitForm(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupère l'ID du quiz à partir de la soumission du formulaire
        $quizId = $request->request->get('quiz_id');
        // Récupère la valeur du score à partir de la soumission du formulaire
        $scoreValue = $request->request->get('score');

        // Crée une nouvelle entité Score et la persiste
        $score = new Score();
        $score->setUser($user); // Associe le score à l'utilisateur actuel

        // Récupère l'objet quiz en fonction de l'ID
        $quiz = $this->entityManager->getRepository(\App\Entity\Quiz::class)->find($quizId);
        if (!$quiz) {
            // Gère le cas où le quiz n'est pas trouvé
            // Par exemple, redirige vers le formulaire avec un message d'erreur
        }

        $score->setQuiz($quiz); // Définit le quiz associé au score
        $score->setScore($scoreValue); // Définit la valeur du score
        $score->setDateCompleted(new \DateTime()); // Définit la date de complétion

        $this->entityManager->persist($score);
        $this->entityManager->flush();

        // Redirige vers la route user_scores
        return $this->redirectToRoute('app_scores_for_user');
    }
}
