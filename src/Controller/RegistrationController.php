<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            // Redirect according creation process (candidate/recrutor/consultant)...
            if ($form->getClickedButton() && 'saveAndCandidate' === $form->getClickedButton()->getName()) {
                return $this->redirectToRoute('app_candidate_creation',array('id' => $user->getId()));
            }
            elseif ($form->getClickedButton() && 'saveAndRecrutor' === $form->getClickedButton()->getName()){
                return $this->redirectToRoute('app_recrutor_creation',array('id' => $user->getId()));
            }
            elseif ($form->getClickedButton() && 'saveAndConsultant' === $form->getClickedButton()->getName()){
                return $this->redirectToRoute('app_consultant_creation',array('id' => $user->getId()));
            }
            else {
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


        #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Stocke la dernière erreur de login
        $error = $authenticationUtils->getLastAuthenticationError();

        // stocke le dernier user
        $lastUser = $authenticationUtils->getLastUsername();

        return $this->render('registration/login.html.twig', [
            'error' => $error,
            'last_user' => $lastUser
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {

    }

    #[Route('/display-user', name: 'app_display_all_user')]
    public function display_all_user(ManagerRegistry $doctrine): Response
    {
        $allUser = $doctrine->getRepository(User::class)->findAll();
        return $this->render('registration/display_all_user.html.twig', [
            'allUser' => $allUser,
        ]);
    }

}
