<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(
        CategoryRepository $categoryRepository,
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        UserRepository $userRepository
    ): Response {
        return $this->render('admin/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'orders' => $orderRepository->findAll(),
            'products' => $productRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }
}
