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
    /**
     * Constructor
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Functions
     */
    #[Route('/register', name: 'register')]
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

            // uses the dd() dump and die function
            // dd($user);

            // registers the user in the database
            $this->em->persist($user);
            $this->em->flush();
        }        
        return $this->render('pages/register/register.html.twig', $params);
    }
}
