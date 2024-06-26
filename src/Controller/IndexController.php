<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Score;
use App\Repository\AnswerRepository;
use App\Repository\LanguageRepository;
use App\Repository\LessonRepository;
use App\Repository\QuizRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    // Page d'accueil de l'application
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    #[Route('/lessons/{id}', name: 'app_list_lesson')]
    // Afficher la liste des leçons
    public function listLessons(LessonRepository $lessonRepository, LanguageRepository $languageRepository, int $id = null): Response
    {
        return $this->render('index/list_lesson.html.twig', [
           "lessons" => $id ? $lessonRepository->findBy(['language' => $id]) : $lessonRepository->findAll(),
           "languages" => $languageRepository->findAll()
        ]);
    }

    #[Route('/mentionslegales', name: 'app_mentions')]
    // Page des mentions légales
    public function mentions(): Response
    {
        return $this->render('index/mentionsLegales.html.twig');
    }

    #[Route('/aproposdenous', name: 'app_a_propos_de_nous')]
    // Page à propos de nous
    public function apropos(): Response
    {
        return $this->render('index/AProposDeNous.html.twig');
    }

    #[Route('/quizzes', name: 'app_quizzes')]
    // Afficher la liste des quizzes
    public function quizzes(QuizRepository $quizRepository): Response
    {
        return $this->render('index/list_quizz.html.twig', [
            'quizzes' => $quizRepository->findAll()
        ]);
    }

    #[Route('/show_quiz/{id}', name: 'app_show_quizz')]
    // Afficher un quiz spécifique
    public function showQuiz(Request $request, Quiz $quiz, AnswerRepository $answerRepository, EntityManagerInterface $entityManager): Response
    {
        $score = new Score();
        $score->setQuiz($quiz);
        $score->setUser($this->getUser());

        if ($request->getMethod() === 'POST') {
            $answers = $_POST['answers'];
            $score->setDateCompleted(new \DateTimeImmutable());

            foreach ($answers as $answer) {
                $answerObjet = $answerRepository->find($answer);
                if ($answerObjet->isIsCorrect()) {
                    $score->setScore($score->getScore() + 1);
                }
            }
            $entityManager->persist($score);
            $entityManager->flush();

            // Récupérer l'URL de redirection à partir de la soumission du formulaire
            $redirectUrl = $request->request->get('redirect_url');

            // Rediriger l'utilisateur vers l'URL spécifiée
            return $this->redirect($redirectUrl);
        }

        return $this->render('index/show_quizz.html.twig', [
            'quiz' => $quiz
        ]);
    }
    
    #[Route('/language_selection', name: 'app_language_selection')]
    // Sélection de la langue
    public function languageSelection(LanguageRepository $languageRepository): Response
    {
        return $this->render('index/language_selection.html.twig', [
            'languages' => $languageRepository->findAll()
        ]);
    }

}
