<?php

namespace App\DataFixtures;

use App\Entity\AdminSysteme;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSystemeFixtures extends Fixture implements DependentFixtureInterface
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

            $AdminSysteme = new AdminSysteme();
            $harsh = $this->encoder->encodePassword($AdminSysteme, 'password');
            // AdminSysteme
            $AdminSysteme->setPrenom($faker->firstname);
            $AdminSysteme->setNom($faker->lastname);
            $AdminSysteme->setPassword($harsh);
            $AdminSysteme->setTelephone($faker->phoneNumber);
            $AdminSysteme->setEmail($faker->email);
            $AdminSysteme->setProfil($this->getReference(ProfilFixtures::adminSysteme));
            //$AdminSysteme->setProfil($this->getReference($p));
            // persist
            $manager->persist($AdminSysteme);
        }
        $manager->flush();

}
public function getDependencies(){
    return array(
        UserFixtures::class,
    );
}
}
