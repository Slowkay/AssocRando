<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    // ===== Constructor =====

    /**
     * Constructor of the RegisterController
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    

    // ===== Functions =====

    /**
     * Return the registration form and inserts a user in the User table
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $hashPassword
     * @return Response
     */
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $hashPassword): Response
    {
        // instantiates an object for the new user
        $user = new User();

        // instantiates the registration form
        $user_form = $this->createForm(RegisterType::class, $user);

        // defines the parameters for the view
        $params = array(
            'user_form' => $user_form->createView()
        );

        // processes the submission of the registration form
        $user_form->handleRequest($request);

        // test if the submitted form is valid
        if($user_form->isSubmitted() && $user_form->isValid())
        {
            // get the form data in the $user object
            $user = $user_form->getData();

            // Hashing mdp
            $hashPassword = $hashPassword->hashPassword($user, $user->getPassword());
            $user->setPassword($hashPassword);

            // registers the user in the database
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }        
        return $this->render('pages/register/register.html.twig', $params);
    }

    
}
