<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    // #[Route('/', name: 'order_index', methods: ['GET'])]
    // public function index(OrderRepository $orderRepository): Response
    // {
    //     return $this->render('order/index.html.twig', [
    //         'orders' => $orderRepository->findAll(),
    //     ]);
    // }

    #[Route('/new', name: 'order_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER")]
    public function new(OrderRepository $orderRepository, ProductRepository $productRepository, SessionInterface $sessionInterface, EntityManagerInterface $entityManager): Response
    {
        $cart = $sessionInterface->get("cart", []);
        if (!empty($cart)) {
            $total = 0;

            foreach ($cart as $id => $quantity) {
                $product = $productRepository->find($id);
                $total += $product->getPrice() * $quantity;
            }

            $order = new Order();
            // $form = $this->createForm(OrderType::class, $order);
            // $form->handleRequest($request);

            // if ($form->isSubmitted() && $form->isValid()) {
            //création de la commande
            $order->setReference(date('YmdHi') . $this->getUser()->getId());
            $order->setState('En cours de validation');
            $order->setUser($this->getUser());
            $order->setTotal($total);
            $entityManager->persist($order);
            $entityManager->flush();

            //récupération de la commande créée enregistrement 
            //des produits pour le détail de la commande
            $orderCreated = $orderRepository->findOneBy(['user' => $this->getUser(), 'reference' => date('YmdHi') . $this->getUser()->getId()]);
            foreach ($cart as $id => $quantity) {
                $orderDetail = new OrderDetail();
                $product = $productRepository->find($id);
                $price = $product->getPrice() * $quantity;

                $product->setStock($product->getStock() - $quantity);

                $orderDetail
                    ->setProduct($product)
                    ->setOrderId($orderCreated)
                    ->setQuantity($quantity)
                    ->setPrice($price);


                $entityManager->persist($orderDetail);
                $entityManager->flush();

                $sessionInterface->remove("cart", []);
            }
            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_shop', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/{id}', name: 'order_show', methods: ['GET'])]
    // public function show(Order $order): Response
    // {
    //     return $this->render('order/show.html.twig', [
    //         'order' => $order,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'order_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER")]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'order_delete', methods: ['POST'])]
    // public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($order);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
    // }
}
