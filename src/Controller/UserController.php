<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType; // Si vous avez un formulaire pour User
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

        // Remplir le formulaire ici, si vous en avez un
        // $form = $this->createForm(UserType::class, $user);
        // $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            // Enregistrer l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Rediriger ou afficher un message
            return $this->redirectToRoute('some_route');
        }

        return $this->render('user/create.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
