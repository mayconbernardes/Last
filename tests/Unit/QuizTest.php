<?php

namespace App\Tests\Unit;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuizTest extends KernelTestCase
{
    public function getEntity(): Quiz
{
    return (new Quiz())
    ->setTitle('Nouveau Titre');
}
public function testTitleIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $quiz = $this->getEntity();

        $errors = $container->get('validator')->validate($quiz);

        $this->assertCount(0, $errors);

    }
    public function testInvalidTitle(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $quiz = $this->getEntity();
        $quiz->setTitle('');

        $errors = $container->get('validator')->validate($quiz);

        $this->assertCount(1, $errors);
    }
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class; // Remplacez cela par le chemin correct de votre classe Kernel
    }
}
