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

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Redirect to the Quiz CRUD page
        return $this->redirect($this->adminUrlGenerator->setController(QuizCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Languedo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-home');
        yield MenuItem::linkToCrud('Quiz', 'fas fa-puzzle-piece', Quiz::class);
        yield MenuItem::linkToCrud('Lesson', 'fas fa-book', Lesson::class);
        yield MenuItem::linkToCrud('Language', 'fas fa-language', Language::class);
        yield MenuItem::linkToCrud('Answer', 'fas fa-check', Answer::class);
        yield MenuItem::linkToCrud('Question', 'fas fa-question', Question::class);
        yield MenuItem::linkToCrud('Score', 'fas fa-star', Score::class);
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);







    }
}
