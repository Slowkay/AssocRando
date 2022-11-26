<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Hiking;
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

            $hike->setNameHinking($nameHike[$i]);
            
            $hike->setPrix($faker->randomNumber(3, true));

            $hike->setMaxPlaces($faker->numberBetween(6, 20));

            $manager->persist($hike);
        }

        $manager->flush();
    }
}
