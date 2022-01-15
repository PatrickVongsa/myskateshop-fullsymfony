<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NavbarController extends AbstractController
{
    public function generateNavbar(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        SessionInterface $sessionInterface,
        bool $bg=true
    ): Response {
        $cart = $sessionInterface->get("cart", []);
        $dataCart = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            $dataCart[] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
            $total += $product->getPrice() * $quantity;
        }

        return $this->render('components/_navbar.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'dataCart' => $dataCart,
            'total' => $total,
            'bg' => $bg,
            ]);
    }
}