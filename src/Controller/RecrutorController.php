<?php

namespace App\Controller;

use App\Entity\Recrutor;
use App\Entity\User;
use App\Form\RecrutorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecrutorController extends AbstractController
{
    #[Route('/recrutor', name: 'app_recrutor')]
    public function index(): Response
    {
        return $this->render('recrutor/index.html.twig', [
            'controller_name' => 'RecrutorController',
        ]);
    }

    #[Route('/recrutor/creation-selection', name: 'app_recrutor_creation_selection')]
    public function create_selection(): Response
    {
        return $this->render('recrutor/create_selection.html.twig', [
            'controller_name' => 'CandidateController',
        ]);
    }

    #[Route('/recrutor/select-user', name: 'app_select_user_for_recrutor')]
    public function select_user(\Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $availableUser = $doctrine->getRepository(User::class)->findAll();
        return $this->render('recrutor/select_user_for_recrutor.html.twig', [
            'availableUser' => $availableUser,
        ]);
    }

    #[Route('/recrutor/select-user-for-recrutor-update', name: 'app_select_user_for_recrutor_update')]
    public function select_user_for_recrutor_update(\Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $availableUser = $doctrine->getRepository(User::class)->findAll();
        return $this->render('recrutor/select_user_for_recrutor_update.html.twig', [
            'availableUser' => $availableUser,
        ]);
    }

    #[Route('/recrutor/creation/{id}', name: 'app_recrutor_creation')]
    public function create_recrutor(Request $request,User $user, EntityManagerInterface $entityManager): Response
    {
        $recrutor = new Recrutor();
        $recrutor->setUser($user);
        $recrutor->getUser()->addRoles("ROLE_RECRUTOR");

        $form = $this->createForm(RecrutorType::class, $recrutor);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($recrutor);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('recrutor/create_recrutor.html.twig', [
            'recrutorCreationForm' => $form->createView(),
        ]);
    }

    #[Route('/recrutor/update/{id}', name: 'app_recrutor_update')]
    public function create_candidate(Request $request,User $user, EntityManagerInterface $entityManager): Response
    {
        $recrutor = $user->getRecrutor();
        $form = $this->createForm(RecrutorType::class, $recrutor);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($recrutor);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('recrutor/create_recrutor.html.twig', [
            'recrutorCreationForm' => $form->createView(),
        ]);
    }

    #[Route('/recrutor/{id}/display-offers', name: 'app_recrutor_display_offers')]
    public function recrutor_display_offers(Request $request,User $user, EntityManagerInterface $entityManager): Response
    {
        $recrutor = $user->getRecrutor();
        $jobOffers = $recrutor->getJobOffers();


        return $this->render('recrutor/recrutor_display_offers.html.twig', [
            'JobOffers' => $jobOffers,
        ]);
    }


}
