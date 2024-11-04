<?php

namespace App\Controller;

use App\Form\ClientType;
use App\Form\ClientFilterType; // Ajout du formulaire de filtre
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

        // Récupérer les données du formulaire
        $filters = $form->isSubmitted() && $form->isValid() ? $form->getData() : [];

        // Vérifier que les filtres ne sont pas null
        $filters = array_filter($filters, fn($value) => !is_null($value) && $value !== '');

        // Appeler la méthode findByFilters
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
            // Récupérer le compte utilisateur depuis le formulaire
            $user = $client->getCompte();

            // Vérifier que l'utilisateur est correctement défini
            if ($user) {
                // Persist the user entity
                $entityManager->persist($user);
            }

            // Persist the client entity
            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Client créé avec succès.');

            return $this->redirectToRoute('client.index');
        }

        // Si le formulaire n'est pas valide, afficher les erreurs
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Il y a des erreurs dans le formulaire. Veuillez vérifier les informations saisies.');
        }

        return $this->render('client/form.html.twig', [
            'formClient' => $form->createView(),
        ]);
    }
}
