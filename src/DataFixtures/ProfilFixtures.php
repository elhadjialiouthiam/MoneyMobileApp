<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ProfilFixtures extends Fixture
{
    public const adminSysteme = 'adminSysteme';
    public const adminAgence = 'adminAgence';
    public const caisier = 'caisier';
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // configurer la langue
        $tab = ['adminSysteme','adminAgence','caisier'];

        for ($p=0; $p < count($tab); $p++) { 
            $profil = new Profil();
            // profiles
            $profil->setLibelle($tab[$p]);
            if($tab[$p]=='adminSysteme'){
                $this->addReference(self::adminSysteme,$profil);
            }
            elseif($tab[$p]=='adminAgence'){
                $this->addReference(self::adminAgence,$profil);

            }
            elseif($tab[$p]=='caisier'){
                $this->addReference(self::caisier,$profil);

            }

            // persist
            $manager->persist($profil);
        }

        $manager->flush();
    }
}
