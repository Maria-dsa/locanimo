<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Availablity;
use App\Form\Animal\AnimalAvailablitiesType;
use App\Form\Animal\AnimalType;
use App\Form\AvailablityType;
use App\Repository\AnimalRepository;
use App\Repository\AvailablityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/animal')]
class AnimalController extends AbstractController
{
    #[Route('/', name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnimalRepository $animalRepository): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $animal->setOwner($user);
            $availablity = new Availablity();
            $animalRepository->save($animal, true);

            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_show', methods: ['GET'])]
    public function show(Animal $animal, AvailablityRepository $availablityRepository): Response
    {
        $availablities = $availablityRepository->findAllByDate();
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
            'availablities' => $availablities
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository->save($animal, true);

            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/add-availablities', name: 'app_animal_availablities_add', methods: ['GET', 'POST'])]
    public function addAvailablities(
        Request $request,
        Animal $animal,
        AnimalRepository $animalRepository,
        AvailablityRepository $availablityRepository
    ): Response {
        $availablity = new Availablity();
        $availablity->setAnimal($animal);
        $form = $this->createForm(AvailablityType::class, $availablity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $availablityRepository ->save($availablity, true);
            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], Response::HTTP_SEE_OTHER );
        }
        return $this->renderForm('availablity/new.html.twig', [
            'form' => $form,
            'animal' => $animal
        ]);
    }

    #[Route('/{id}/edit-availablities', name: 'app_animal_availablities_edit', methods: ['GET', 'POST'])]
    public function editAvailablities(
        Request $request,
        Animal $animal,
        AnimalRepository $animalRepository
    ): Response {
        $form = $this->createForm(AnimalAvailablitiesType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository ->save($animal, true);

            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], Response::HTTP_SEE_OTHER );
        }
        return $this->renderForm('animal/edit-availablities.html.twig', [
            'form' => $form,
            'animal' => $animal
        ]);
    }



    #[Route('/{id}', name: 'app_animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->request->get('_token'))) {
            $animalRepository->remove($animal, true);
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}
