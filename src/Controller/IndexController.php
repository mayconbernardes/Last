<?php

namespace App\Controller;

use App\Repository\LanguageRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    #[Route('/lessons/{id}', name: 'app_list_lesson')]
    public function listLessons(LessonRepository $lessonRepository, LanguageRepository $languageRepository, int $id = null): Response
    {
        return $this->render('index/list_lesson.html.twig', [
           "lessons" => $id ? $lessonRepository->findBy(['language' => $id]) : $lessonRepository->findAll(),
           "languages" => $languageRepository->findAll()
        ]);
    }

    #[Route('/mentionslegales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('index/mentionsLegales.html.twig');
    }
}
