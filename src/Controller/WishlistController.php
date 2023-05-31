<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Wishlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishlistController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/wishlist/add/{id<\d+>}", name="add_to_wishlist")
     */
    public function addToWishlist(Car $car): Response
    {
        $user = $this->getUser();

        $wishlist = new Wishlist();
        $wishlist->setCar($car);
        $wishlist->setUser($user);

        $this->entityManager->persist($wishlist);
        $this->entityManager->flush();

        $this->addFlash('success', 'Car added to wishlist!');
        return $this->redirectToRoute('app_cars');
    }
}
