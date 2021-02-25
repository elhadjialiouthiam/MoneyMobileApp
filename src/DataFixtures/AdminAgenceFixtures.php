<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\AdminAgence;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\ProfilFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminAgenceFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for($a=1;$a<=5;$a++){

            $AdminAgence = new AdminAgence();
            $harsh = $this->encoder->encodePassword($AdminAgence, 'password');
            // AdminAgence
            $AdminAgence->setPrenom($faker->firstname);
            $AdminAgence->setNom($faker->lastname);
            $AdminAgence->setPassword($harsh);
            $AdminAgence->setTelephone($faker->phoneNumber);
            $AdminAgence->setEmail($faker->email);
            $AdminAgence->setProfil($this->getReference(ProfilFixtures::adminAgence));
            $manager->persist($AdminAgence);
            
        }
            
            // persist
            $manager->flush();
               
}
public function getDependencies(){
    return array(
        UserFixtures::class,
    );
}
}
