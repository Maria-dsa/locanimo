<?php

namespace App\Controller;

use App\Entity\ScheduleRental;
use App\Form\ScheduleRental\RentalValidationType;
use App\Form\ScheduleRental\ScheduleRentalType;
use App\Repository\AnimalRepository;
use App\Repository\AvailablityRepository;
use App\Repository\ScheduleRentalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/schedule/rental')]
class ScheduleRentalController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/owner', name: 'app_schedule_rental_owner', methods: ['GET'])]
    public function indexOwner(ScheduleRentalRepository $scheduleRentalRepository): Response
    {
        $user = $this->getUser();
        return $this->render('schedule_rental/owner.html.twig', [
            'scheduleRentals' => $scheduleRentalRepository->findAllByOwner($user),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/customer', name: 'app_schedule_rental_customer', methods: ['GET'])]
    public function indexCustomer(ScheduleRentalRepository $scheduleRentalRepository): Response
    {
        $user = $this->getUser();
        return $this->render('schedule_rental/customer.html.twig', [
            'scheduleRentals' => $scheduleRentalRepository->findAllByCustomer($user),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/new/{animalId}', name: 'app_schedule_rental_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ScheduleRentalRepository $scheduleRentalRepository,
        AvailablityRepository $availablityRepository,
        AnimalRepository $animalRepository,
        int $animalId
    ): Response {
        $scheduleRental = new ScheduleRental();
        $animal = $animalRepository->findOneBy(['id' =>$animalId]);
        $user = $this->getUser();
        $form = $this->createForm(ScheduleRentalType::class, $scheduleRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $startRent = $scheduleRental->getStartedAt();
            $endRent = $scheduleRental->getendedAt();
            $start_timestamp = strtotime($startRent->format("Y-m-d"));
            $end_timestamp = strtotime($endRent->format("Y-m-d"));
            $nbDays = ($end_timestamp - $start_timestamp) / 86400;

            $availablities = $availablityRepository ->findAll();
            foreach ($availablities as $availablity) {
               if($startRent >= $availablity->getStartedAt() && $endRent <= $availablity->getEndedAt()) {
                   $billAmount = $nbDays * $availablity->getDailyPrice() ;
                   $scheduleRental->setBillAmount($billAmount);
                   $scheduleRental->setAnimal($animal);
                   $scheduleRental->setCustomer($user);
                   $scheduleRental->setStatus('pending');
                   $scheduleRentalRepository->save($scheduleRental, true);
                   $this->addFlash('success', "Votre réservation a bien été prise en compte. 
                   La montant prévu est de " . $billAmount . " €. Merci !");
                }
            }
            if($scheduleRental->getId()===null) {
                $this->addFlash('danger', "Période non disponible, veuillez consulter les disponibilités !");
            }
            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('schedule_rental/new.html.twig', [
            'schedule_rental' => $scheduleRental,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_schedule_rental_show', methods: ['GET'])]
    public function show(ScheduleRental $scheduleRental): Response
    {
        return $this->render('schedule_rental/show.html.twig', [
            'schedule_rental' => $scheduleRental,
        ]);
    }
//uniquement pour le owner
    #[IsGranted('ROLE_USER')]
    #[Route('/validation/{id}', name: 'app_schedule_validation_show', methods: ['GET', 'POST'])]
    public function validation(
        ScheduleRental $scheduleRental,
        Request $request,
        ScheduleRentalRepository $scheduleRentalRepository
    ): Response {
        $form = $this->createForm(RentalValidationType::class, $scheduleRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scheduleRentalRepository->save($scheduleRental, true);

            //modifier le redirect
            return $this->redirectToRoute('app_schedule_rental_owner', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('schedule_rental/validation_show.html.twig', [
            'schedule_rental' => $scheduleRental,
            'form' => $form,
        ]);
    }
//uniquement pour le customer
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edit', name: 'app_schedule_rental_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ScheduleRental $scheduleRental, ScheduleRentalRepository $scheduleRentalRepository): Response
    {
        $form = $this->createForm(ScheduleRentalType::class, $scheduleRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scheduleRentalRepository->save($scheduleRental, true);

            return $this->redirectToRoute('app_schedule_rental_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('schedule_rental/edit.html.twig', [
            'schedule_rental' => $scheduleRental,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_schedule_rental_delete', methods: ['POST'])]
    public function delete(Request $request, ScheduleRental $scheduleRental, ScheduleRentalRepository $scheduleRentalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scheduleRental->getId(), $request->request->get('_token'))) {
            $scheduleRentalRepository->remove($scheduleRental, true);
        }

        return $this->redirectToRoute('app_schedule_rental_index', [], Response::HTTP_SEE_OTHER);
    }
}
