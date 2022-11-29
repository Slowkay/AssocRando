<?php

namespace App\Controller;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Form\EditPasswordType;

class SecurityController extends AbstractController
{


    // ===== Constructor =====

    /**
     * Constructor of the SecurityController
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    // ===== Functions =====

    /**
     * Return the login form
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * Allows you to disconnect the User
     *
     * @return void
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * Returns the User modification form and modifies it
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $hashPassword
     * @return Response
     */
    #[Route(path: '/user_account', name:'user_account')]
    #[IsGranted('ROLE_USER')]
    public function user_account(Request $request, UserPasswordHasherInterface $hashPassword): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        
        return $this->render('pages/user/user.html.twig', [
            'form' => $form->createView()            
        ]);
    }

   
    /**
     * Returns a User's password change form and modifies it
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordHasherInterface $hashPassword
     * @return Response
     */
    #[Route(path: '/editPassword/{id}', name:'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, UserPasswordHasherInterface $hashPassword) :Response
    {
        $form = $this->createForm(EditPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {   
            if($hashPassword->isPasswordValid($user, $form->getData()['password'])){
                $user->setPassword(
                    $hashPassword->hashPassword(
                        $user,
                        $form->getData()['newPassword']
                        // Edit getData() for more security
                    )
                );
                
                dd($user->getPassword());
                $this->em->persist($user);
                $this->em->flush();
                return $this->redirectToRoute('user_account');
            }  
        }
        
        return $this->render('pages/user/editPassword.html.twig', [
            'form' => $form->createView()            
        ]);
    }
    
}
