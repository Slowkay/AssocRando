<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Hiking;
use App\Entity\Session;
use App\Entity\User;
use Faker;

class AppFixtures extends Fixture
{

    private $encoder;
    
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        
        $nameHike = array('Le GR20 en Corse', 'Mont-Blanc', 'Stevenson', 'Saint Jacques de Compostelle', 'Traversée des Pyrénées', 'entier des Douaniers', 'Les Calanques', 'Tour du Queyras');

        /**
         * Creation of hikes
         */
        for($i=0; $i<8; $i++)
        {        
            $hike = new Hiking();

            $hike->setNameHiking($nameHike[$i]);
            
            $hike->setPrix($faker->randomNumber(3, true));

            $hike->setMaxPlaces($faker->numberBetween(6, 20));
            
            $hike->setdescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec viverra quis ligula ut egestas.");

            $manager->persist($hike);
        }

        /**
         * *Création des utilisateurs*/
        //
        $admin = new User();
        $admin->setEmail('robin.guesdon@gmail.com');
        $lesRoles=array('admin');
        $admin->setRoles($lesRoles)
            ->setPassword('root')
            ->setNom('GUESDON')        
            ->setPrenom('Robin');
        $manager->persist($admin);

        $lesGenres=['male','female'];
        for($i=0;$i<5;$i++)
        {
            
            $user=new User();
            $user->setEmail($faker->freeEmail);
            $lesRoles=array('user');
            $hash = ($this->encoder->hashPassword(
                $user,
                'the_new_password'
                ));
            $user->setRoles($lesRoles)            
                ->setPassword($hash)            
                ->setNom($faker->lastName);
            $unGenre=$faker->randomElement($lesGenres);
            $user->setPrenom($faker->firstName());
            if($unGenre=='male')
                $user->setPrenom($faker->firstNameMale());
            else
                $user->setPrenom($faker->firstNameFemale());
            $manager->persist($user);
            
        }

        $hiketest = new Hiking();
        $hiketest->setNameHiking("test");
        $hiketest->setPrix(123);
        $hiketest->setMaxPlaces(1);
        $hiketest->setdescription("description test");

        $session = new Session();
        $session->setDate(date_create("25-09-2003"));
        $session->setHike($hiketest);

        $session2 = new Session();
        $session2->setDate(date_create("25-09-2003"));
        $session2->setHike($hiketest);

        $manager->persist($hiketest);
        $manager->persist($session);
        $manager->persist($session2);
        $manager->flush();
    }
}
