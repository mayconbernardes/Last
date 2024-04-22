<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Language;
use App\Entity\Lesson;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\Score;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;

    // Constructeur pour injecter AdminUrlGenerator
    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    // Action Index pour le tableau de bord de l'administration
    public function index(): Response
    {
        // Redirige vers la page CRUD de Quiz
        return $this->redirect($this->adminUrlGenerator->setController(QuizCrudController::class)->generateUrl());
    }

    // Configure l'apparence du tableau de bord
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Languedo');
    }

    // Configure les éléments de menu affichés dans la barre latérale
    public function configureMenuItems(): iterable
    {
        // Définit des liens vers différentes pages CRUD
        yield MenuItem::linkToDashboard('Tableau de bord', 'fas fa-home');
        yield MenuItem::linkToCrud('Quiz', 'fas fa-puzzle-piece', Quiz::class);
        yield MenuItem::linkToCrud('Leçon', 'fas fa-book', Lesson::class);
        yield MenuItem::linkToCrud('Langue', 'fas fa-language', Language::class);
        yield MenuItem::linkToCrud('Réponse', 'fas fa-check', Answer::class);
        yield MenuItem::linkToCrud('Question', 'fas fa-question', Question::class);
        yield MenuItem::linkToCrud('Score', 'fas fa-star', Score::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
    }
}
