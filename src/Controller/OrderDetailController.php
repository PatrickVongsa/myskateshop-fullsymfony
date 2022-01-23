<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use App\Repository\OrderDetailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order/detail')]
class OrderDetailController extends AbstractController
{
    // #[Route('/', name: 'order_detail_index', methods: ['GET'])]
    // public function index(OrderDetailRepository $orderDetailRepository): Response
    // {
    //     return $this->render('order_detail/index.html.twig', [
    //         'order_details' => $orderDetailRepository->findAll(),
    //     ]);
    // }

    // #[Route('/new', name: 'order_detail_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $orderDetail = new OrderDetail();
    //     $form = $this->createForm(OrderDetailType::class, $orderDetail);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($orderDetail);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('order_detail_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('order_detail/new.html.twig', [
    //         'order_detail' => $orderDetail,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'order_detail_show', methods: ['GET'])]
    // public function show(OrderDetail $orderDetail): Response
    // {
    //     return $this->render('order_detail/show.html.twig', [
    //         'order_detail' => $orderDetail,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'order_detail_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, OrderDetail $orderDetail, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(OrderDetailType::class, $orderDetail);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('order_detail_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('order_detail/edit.html.twig', [
    //         'order_detail' => $orderDetail,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'order_detail_delete', methods: ['POST'])]
    // public function delete(Request $request, OrderDetail $orderDetail, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$orderDetail->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($orderDetail);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('order_detail_index', [], Response::HTTP_SEE_OTHER);
    // }
}
