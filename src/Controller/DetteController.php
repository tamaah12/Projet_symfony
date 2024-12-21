<?php

namespace App\Controller;

use App\Entity\Dette;
use App\Form\DetteFilterType;
use App\Form\DetteType;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{
    #[Route('/dette/liste', name: 'dette.index')]
    public function index(Request $request, DetteRepository $detteRepository): Response
    {
        // Création du formulaire de filtrage
        $form = $this->createForm(DetteFilterType::class);
        $form->handleRequest($request);

        // Gestion des filtres
        $filters = $form->isSubmitted() && $form->isValid() ? $form->getData() : [];
        $filters = array_filter($filters, fn($value) => !is_null($value) && $value !== '');

        // Récupération des données des dettes avec filtres
        $dataDettes = $detteRepository->findByFilters($filters);

        // Rendu de la vue avec les données
        return $this->render('dette/index.html.twig', [
            'dataDettes' => $dataDettes,
            'filterForm' => $form->createView(),
        ]);
    }

    #[Route('/dette/create', name: 'dette.create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dette = new Dette();
        $form = $this->createForm(DetteType::class, $dette);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persistance de la dette
            $entityManager->persist($dette);
            $entityManager->flush();

            // Redirection vers la liste des dettes après ajout
            return $this->redirectToRoute('dette.index');
        }

        // Rendu de la vue pour le formulaire de création
        return $this->render('dette/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/dette/{id}', name: 'dette.details')]
    public function details(int $id, DetteRepository $detteRepository): Response
    {
        $dette = $detteRepository->find($id);

        if (!$dette) {
            throw $this->createNotFoundException('La dette n\'existe pas');
        }

        return $this->render('dette/details.html.twig', [
            'dette' => $dette,
        ]);
    }
}
