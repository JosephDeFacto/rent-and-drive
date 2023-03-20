<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/registration", name="app_registration")
     */
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            ));

            $user->setRoles(['ROLE_USER']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');

        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
