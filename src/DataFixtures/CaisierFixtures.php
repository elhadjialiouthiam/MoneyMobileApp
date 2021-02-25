<?php

namespace App\DataFixtures;

use App\Entity\Caisier;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CaisierFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
            $faker = Factory::create('fr_FR');
            for($a=1;$a<=5;$a++){
            $Caisier = new Caisier();
            $harsh = $this->encoder->encodePassword($Caisier, 'password');
            // Caisier
            $Caisier->setPrenom($faker->firstname);
            $Caisier->setNom($faker->lastname);
            $Caisier->setPassword($harsh);
            $Caisier->setTelephone($faker->phoneNumber);
            $Caisier->setEmail($faker->email);
            $Caisier->setProfil($this->getReference(ProfilFixtures::caisier));
            //$Caisier->setProfil($this->getReference($p));
            // persist
            $manager->persist($Caisier);
            }
            $manager->flush();
    
}
public function getDependencies(){
    return array(
        ProfilFixtures::class,
    );
}

}