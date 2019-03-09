<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        
        for ($i = 0; $i < 100; $i ++){

            $property = new Property();
            $property
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(20, 350))
                ->setRooms($faker->numberBetween(2, 10))
                ->setBedRooms($faker->numberBetween(1, 9))
                ->setFloors($faker->numberBetween(0, 15))
                ->setPrice($faker->numberBetween(100000, 100000))
                ->setCity($faker->numberBetween(0, cout(Property::HEAT)-1))
                ->setAdress($faker->adress)
                ->setPostalCode($faker->postalcode)
                ->setSold(false);
            $manager->persist($property);
                
            
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
