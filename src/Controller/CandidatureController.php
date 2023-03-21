<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Candidature;
use App\Entity\JobOffer;
use App\Entity\User;
use App\Form\CandidateType;
use App\Form\CandidatureType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{


//    #[Route('/candidature/creation', name: 'app_candidature_creation')]
//    public function create_candidate(Request $request,User $user, EntityManagerInterface $entityManager): Response
//    {
//        $candidature = new Candidature();
//        $candidate->setUser($user);
//        $candidate->getUser()->addRoles("ROLE_CANDIDATE");
//
//        $form = $this->createForm(CandidatureType::class, $candidature);
//        $form->handleRequest($request);
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $entityManager->persist($candidate);
//            $entityManager->flush();
//            // do anything else you need here, like send an email
//
//            return $this->redirectToRoute('app_home');
//        }
//
//        return $this->render('candidate/create_candidate.html.twig', [
//            'partnerCreationForm' => $form->createView(),
//        ]);
//    }

    #[Route('/candidature/display/{id}', name: 'app_candidature_display')]
    public function create_candidate(JobOffer $jobOffer): Response
    {
        $candidatures = $jobOffer->getCandidatures();

        return $this->render('candidature/display_candidatures.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }

    #[Route('/candidature/to-validate/{id}', name: 'app_display_candidature_to_validate')]
    public function display_candidature_to_validate(JobOffer $jobOffer, ManagerRegistry $doctrine): Response
    {
        $candidatures = $doctrine->getRepository(Candidature::class)->findAllCandidaturesToValidate();
        return $this->render('candidature/display_candidatures.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }



//    #[Route('/jobOffer/{id}/validation/{id_user}', name: 'app_jobOffer_activation')]
//    #[ParamConverter('user', options: ['id' => 'id_user'])]
//    public function jobOffer_activation(JobOffer $jobOffer, User $user,ManagerRegistry $doctrine)
//    {
//        $tempconsultant=$user->getConsultant();
//        $jobOffer->setValidated(($jobOffer->isValidated()) ? false : true);
//        $jobOffer->setConsultant($tempconsultant);
//        $entityManager=$doctrine->getManager();
//        $entityManager->persist($jobOffer);
//        $entityManager->flush();
//
//        return new Response('true');
//    }


}
