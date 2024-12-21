<?php

namespace App\Controller;

use App\Form\ClientType;
use App\Form\ClientFilterType;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client/liste', name: 'client.index')]
    public function index(Request $request, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientFilterType::class);
        $form->handleRequest($request);


        $filters = $form->isSubmitted() && $form->isValid() ? $form->getData() : [];


        $filters = array_filter($filters, fn($value) => !is_null($value) && $value !== '');


        $clients = $clientRepository->findByFilters($filters);

        return $this->render('client/index.html.twig', [
            'dataClients' => $clients,
            'filterForm' => $form->createView(),
        ]);
    }

    #[Route('/client/create', name: 'client.create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $client->getCompte();


            if ($user) {

                $entityManager->persist($user);
            }


            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Client créé avec succès.');

            return $this->redirectToRoute('client.index');
        }


        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Il y a des erreurs dans le formulaire. Veuillez vérifier les informations saisies.');
        }

        return $this->render('client/form.html.twig', [
            'formClient' => $form->createView(),
        ]);
    }
}
