<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Consultant;
use App\Entity\User;
use App\Form\CandidateType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultantController extends AbstractController
{
    #[Route('/consultant/select-user', name: 'app_select_user_for_consultant_creation')]
    public function select_user_for_consultant(ManagerRegistry $doctrine): Response
    {
        $availableUser = $doctrine->getRepository(User::class)->findAll();
        return $this->render('consultant/select_user_for_consultant_creation.html.twig', [
            'availableUser' => $availableUser,
        ]);
    }

    #[Route('/consultant/creation/{id}', name: 'app_consultant_creation')]
    public function create_candidate(Request $request,User $user, EntityManagerInterface $entityManager): Response
    {
        $consultant = new Consultant();
        $consultant->setUser($user);
        $consultant->getUser()->addRoles("ROLE_CONSULTANT");

        $entityManager->persist($consultant);
        $entityManager->flush();
        // do anything else you need here, like send an email

        return $this->redirectToRoute('app_home');


    }

}
