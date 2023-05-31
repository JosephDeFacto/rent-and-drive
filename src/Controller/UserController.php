<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private BookingRepository $bookingRepository;

    public function __construct(UserRepository $userRepository, BookingRepository $bookingRepository)
    {
        $this->userRepository = $userRepository;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $userInfo = $this->userRepository->find($user);

        return $this->render('user/index.html.twig', ['userInfo' => $userInfo]);
    }

    /**
     * @Route("/user/bookings", name="user_bookings")
     */
    public function myBookings(): Response
    {
        $user = $this->getUser();

        $orders = $this->bookingRepository->findBy(['user' => $user]);

        return $this->render('user/orders.html.twig', ['orders' => $orders]);
    }
}
