<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/mon-compte', name: 'app_account')]
    #[IsGranted('ROLE_USER')]
    public function myAccount(): Response
    {
        $user = $this->getUser();
        return $this->render('home/account.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/boutique', name: 'app_shop')]
    public function shopShow(CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        return $this->render('home/shop-show.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/boutique/{slug}', name: 'app_category_page')]
    public function categoryShow(Category $category): Response
    {
        return $this->render('home/category-show.html.twig', [
            'category' => $category,
        ]);
    }
    
    #[Route('/boutique/{category_slug}/{product_slug}', name: 'app_product_detail')]
    #[ParamConverter('category', options: ['mapping' => ['category_slug' => 'slug']])]
    #[ParamConverter('product', options: ['mapping' => ['product_slug' => 'slug']])]
    public function productShow(Category $category, Product $product): Response
    {
        return $this->render('home/product-show.html.twig', [
            'category' => $category,
            'product' => $product
        ]);
    }

}
