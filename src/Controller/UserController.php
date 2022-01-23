<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeEdit;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/user')]
class UserController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user
                ->setPassword($hashedPassword)
                ->setRoles(["ROLE_ADMIN"])
                ->setIsVerified(true);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    // public function show(User $user): Response
    // {
    //     return $this->render('user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, Security $security): Response
    {
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(UserTypeEdit::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            if ($security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
