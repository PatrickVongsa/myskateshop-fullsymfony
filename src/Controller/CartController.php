<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mon-panier', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $sessionInterface, ProductRepository $productRepository): Response
    {
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

        return $this->render('cart/index.html.twig', [
            'dataCart' => $dataCart,
            'total' => $total
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Product $product, SessionInterface $sessionInterface)
    {
        //récuperer les quantités envoyé par le formulaire
        // dd($_POST);
        $quantity = 0;
        if (isset($_POST['quantity']) && $_POST['quantity'] > 0) {
            $quantity = $_POST['quantity'];
        }
        //onrécupère le panier actuel sinon on lui attribut un panier vide
        $cart = $sessionInterface->get("cart", []);

        //on récupère l'id du produit
        $id = $product->getId();

        //on verifie si l'id est présent si oui on incrémente si non on lui attribut qté = 1
        if (!empty($cart[$id])) {
            $quantity > 0 ? $cart[$id]+= $quantity : $cart[$id]++;
        } else {
            $quantity > 0 ? $cart[$id] = $quantity : $cart[$id] = 1;
        }

        $sessionInterface->set('cart', $cart);

        return $this->redirectToRoute('cart_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Product $product, SessionInterface $sessionInterface): Response
    {
        //onrécupère le panier actuel sinon on lui attribut un panier vide
        $cart = $sessionInterface->get("cart", []);

        //on récupère l'id du produit
        $id = $product->getId();

        //on verifie si l'id est présent et en quatité supérieur à 1 si oui on décrémente si non on le supprime
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $sessionInterface->set('cart', $cart);

        return $this->redirectToRoute('cart_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Product $product, SessionInterface $sessionInterface): Response
    {
        //onrécupère le panier actuel sinon on lui attribut un panier vide
        $cart = $sessionInterface->get("cart", []);

        //on récupère l'id du produit
        $id = $product->getId();

        //on verifie si l'id est présent si oui on le supprime
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $sessionInterface->set('cart', $cart);

        return $this->redirectToRoute('cart_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/clear', name: 'clear')]
    public function clear(SessionInterface $sessionInterface): Response
    {
        //on supprime le cookie "panier"
        $sessionInterface->remove("cart");

        return $this->redirectToRoute('cart_index', [], Response::HTTP_SEE_OTHER);
    }
}
