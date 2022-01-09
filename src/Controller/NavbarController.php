<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function generateNavbar(
        bool $bg=true,
        CategoryRepository $categoryRepository
    ): Response {
        return $this->render('components/_navbar.html.twig', [
            'bg' => $bg,
            'categories' => $categoryRepository->findAll(),
            ]);
    }
}