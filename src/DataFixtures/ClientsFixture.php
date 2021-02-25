<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Clients;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\ClientsPasswordEncoderInterface;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
    }
}
