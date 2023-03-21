<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\JobOffer;
use App\Entity\User;
use App\Form\JobOfferType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobOfferController extends AbstractController
{
    #[Route('/jobOffer/creation/{id}', name: 'app_jobOffer_creation')]
    public function create_jobOffer(Request $request,User $user, EntityManagerInterface $entityManager): Response
    {
        $jobOffer = new JobOffer();
        $jobOffer->setValidated(false);

        $tempRecrutor = $user->getRecrutor();
        dump($tempRecrutor);
        $jobOffer->setRecrutor($tempRecrutor);


        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($jobOffer);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('job_offer/create_jobOffer.html.twig', [
            'jobOfferCreationForm' => $form->createView(),
        ]);
    }

//    #[Route('/display/validated-jobOffer', name: 'app_display_validated_jobOffer')]
//    public function display_validated_jobOffer(ManagerRegistry $doctrine): Response
//    {
//        $JobOffers = $doctrine->getRepository(JobOffer::class)->findAllValidatedOffers();
//        return $this->render('job_offer/display_validated_jobOffer.html.twig', [
//            'JobOffers' => $JobOffers,
//        ]);
//    }

    #[Route('/display/validated-jobOffer', name: 'app_display_validated_jobOffer')]
    public function display_validated_jobOffer(ManagerRegistry $doctrine): Response
    {
        $JobOffers = $doctrine->getRepository(JobOffer::class)->findAllValidatedOffers();
        $currentUserId = $this->getUser()->getId();
        $alreadyPostulated = [];

        foreach ($JobOffers as $Joboffer){
            $Candidatures = $Joboffer->getCandidatures();
            Foreach ($Candidatures as $Candidature){
               if($Candidature->getCandidate()->getUser()->getId() == $currentUserId){
                   $alreadyPostulated[] = $Joboffer;
                   unset($JobOffers[array_search($Joboffer, $JobOffers)]);
                   break;
               }
            }
        }
        return $this->render('job_offer/display_validated_jobOffer.html.twig', [
            'JobOffers' => $JobOffers,
            'AlreadyPostulated' => $alreadyPostulated
        ]);
    }


    #[Route('/display/toValidate-jobOffer', name: 'app_display_jobOffer_to_validate')]
    public function display_jobOffer_to_validate(ManagerRegistry $doctrine): Response
    {
        $JobOffers = $doctrine->getRepository(JobOffer::class)->findAllOffersToValidate();
        return $this->render('job_offer/display_jobOffer_toValidate.html.twig', [
            'JobOffers' => $JobOffers,
        ]);
    }

//    #[Route('/jobOffer/{id_offer}/validation/{id_user}', name: 'app_jobOffer_activation')]
//    #[ParamConverter('jobOffer', options: ['id' => 'id_offer'])]
//    #[ParamConverter('user', options: ['id' => 'id_user'])]
//    public function jobOffer_activation(JobOffer $jobOffer, User $user,ManagerRegistry $doctrine):Response
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

//      Je ne sais pas pourquoi avec cette orthographe de route ça n'a jamais marché
//    #[Route('/jobOffer/{id}/validation', name: 'app_jobOffer_activation')]
//    public function jobOffer_activation(JobOffer $jobOffer, ManagerRegistry $doctrine):Response
//    {
//        dump($jobOffer);
//        $tempconsultant=$this->getUser()->getConsultant();
//        $jobOffer->setValidated(($jobOffer->isValidated()) ? false : true);
//        $jobOffer->setConsultant($tempconsultant);
//        $entityManager=$doctrine->getManager();
//        $entityManager->persist($jobOffer);
//        $entityManager->flush();
//
//        return new Response('true');
//    }

    #[Route('/offer_validation/{id}')]
    public function jobOffer_activation(JobOffer $jobOffer, ManagerRegistry $doctrine):Response
    {
        $currentUser = $this->getUser();

        $jobOffer->setValidated(($jobOffer->isValidated()) ? false : true);
        $jobOffer->setConsultant($currentUser->getConsultant());

        $entityManager=$doctrine->getManager();
        $entityManager->persist($jobOffer);
        $entityManager->flush();

        return new Response('true');
    }


    #[Route('/jobOffer/{id}/postuler/{id_user}', name: 'app_jobOffer_activation')]
    #[ParamConverter('user', options: ['id' => 'id_user'])]
    public function postuler(JobOffer $jobOffer, User $user,ManagerRegistry $doctrine):Response
    {
        $tempcandidate=$user->getCandidate();
        $candidature = new Candidature();
        $candidature->setCandidate($tempcandidate);
        $candidature->setJobOffer($jobOffer);
        $candidature->setValidated(false);


        $entityManager=$doctrine->getManager();
        $entityManager->persist($candidature);
        $entityManager->flush();

        return new Response('true');
    }

    #[Route('/cancel_candidature/{id}', name: 'app_cancel_candidature')]
    public function cancel_candidature(JobOffer $jobOffer, ManagerRegistry $doctrine): Response
    {
        $currentCandidate = $this->getUser()->getCandidate();
        $doctrine->getRepository(Candidature::class)->cancelCandidature($currentCandidate, $jobOffer);
        return new Response('true');

    }

}
