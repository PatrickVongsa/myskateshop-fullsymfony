<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function generateFooter(
        CategoryRepository $categoryRepository
    ): Response {
        return $this->render('components/footer.html.twig', [
            'categories' => $categoryRepository->findAll(),
            ]);
    }
}