<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
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
  
    #[Route('/panier', name: 'app_checkout')]
    public function checkout(): Response
    {
        return $this->render('home/checkout.html.twig');
    }

    #[Route('/mon-compte', name: 'app_account')]
    public function myAccount(): Response
    {
        return $this->render('home/account.html.twig');
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
