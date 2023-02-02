<?php

namespace App\Controller;

use App\Entity\Availablity;
use App\Form\AvailablityType;
use App\Repository\AvailablityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/availablity')]
class AvailablityController extends AbstractController
{
    #[Route('/', name: 'app_availablity_index', methods: ['GET'])]
    public function index(AvailablityRepository $availablityRepository): Response
    {
        return $this->render('availablity/index.html.twig', [
            'availablities' => $availablityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_availablity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AvailablityRepository $availablityRepository): Response
    {
        $availablity = new Availablity();
        $form = $this->createForm(AvailablityType::class, $availablity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $availablityRepository->save($availablity, true);

            return $this->redirectToRoute('app_availablity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('availablity/new.html.twig', [
            'availablity' => $availablity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_availablity_show', methods: ['GET'])]
    public function show(Availablity $availablity): Response
    {
        return $this->render('availablity/show.html.twig', [
            'availablity' => $availablity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_availablity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Availablity $availablity, AvailablityRepository $availablityRepository): Response
    {
        $form = $this->createForm(AvailablityType::class, $availablity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $availablityRepository->save($availablity, true);

            return $this->redirectToRoute('app_availablity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('availablity/edit.html.twig', [
            'availablity' => $availablity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_availablity_delete', methods: ['POST'])]
    public function delete(Request $request, Availablity $availablity, AvailablityRepository $availablityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$availablity->getId(), $request->request->get('_token'))) {
            $availablityRepository->remove($availablity, true);
        }

        return $this->redirectToRoute('app_availablity_index', [], Response::HTTP_SEE_OTHER);
    }
}
