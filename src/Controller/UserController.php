<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'user_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        

        if ($request->isMethod('POST')) {

            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('some_route');
        }

        return $this->render('user/create.html.twig', [

        ]);
    }
}
