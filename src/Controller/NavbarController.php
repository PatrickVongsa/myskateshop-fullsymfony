<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function generateNavbar(
        CategoryRepository $categoryRepository,
        bool $bg=true
    ): Response {
        return $this->render('components/_navbar.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'bg' => $bg,
            ]);
    }
}