<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Hash password
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;




class SecurityController extends AbstractController
{



    /**
     * @Route("/inscription", name="security_registration")
     */

    public function registration(Request $request, ObjectManager $manager, UserPassWordEncoderInterface  $encoder)
    {


        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
            ->add('save', SubmitType::class, ['label' => 'créer un compte'])
           ->getForm();

        $form->handleRequest($request);
        dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
       
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        dump($lastUsername, $error);

        return $this->render('security/login.html.twig', 
        [   'last_username' => $lastUsername, 
            'error' => $error
        ]);
    }


    /**
     * @Route("/logout", name="security_logout")
     */

    public function logout(){

    }
}

