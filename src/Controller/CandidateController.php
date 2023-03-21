<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\CandidateType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CandidateController extends AbstractController
{
    #[Route('/candidate/creation-selection', name: 'app_candidate_creation-selection')]
    public function create_selection(): Response
    {
        return $this->render('candidate/create_selection.html.twig', [
            'controller_name' => 'CandidateController',
        ]);
    }




    #[Route('/candidate/creation/{id}', name: 'app_candidate_creation')]
    public function create_candidate(Request $request,User $user, EntityManagerInterface $entityManager): Response
    {
        $candidate = new Candidate();
        $candidate->setUser($user);
        $candidate->getUser()->addRoles("ROLE_CANDIDATE");

        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($candidate);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('candidate/create_candidate.html.twig', [
            'partnerCreationForm' => $form->createView(),
        ]);
    }

    #[Route('/candidate/update/{id}', name: 'app_candidate_update')]
    public function update_candidate(Request $request,User $user, EntityManagerInterface $entityManager): Response
    {

        $candidate = $user->getCandidate();
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($candidate);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('candidate/create_candidate.html.twig', [
            'partnerCreationForm' => $form->createView(),
        ]);
    }


    #[Route('/candidate/select-user', name: 'app_select_user')]
    public function select_user(ManagerRegistry $doctrine): Response
    {
        $availableUser = $doctrine->getRepository(User::class)->findAll();
        return $this->render('candidate/select_user.html.twig', [
            'availableUser' => $availableUser,
        ]);
    }

    #[Route('/candidate/select-user-for-candidate-update', name: 'app_select_user_for_candidate_update')]
    public function select_user_for_candidate_update(ManagerRegistry $doctrine): Response
    {
        $availableUser = $doctrine->getRepository(User::class)->findAll();
        return $this->render('candidate/select_user_for_candidate_update.html.twig', [
            'availableUser' => $availableUser,
        ]);
    }

    //Checker c'est quoi ça ????
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

}
