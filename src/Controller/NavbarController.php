<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function generateNavbar(
        CategoryRepository $categoryRepository
    ): Response {
        return $this->render('components/navbar.html.twig', [
            'categories' => $categoryRepository->findAll(),
            ]);
    }
}