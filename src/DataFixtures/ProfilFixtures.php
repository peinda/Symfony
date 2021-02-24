<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilFixtures extends Fixture
{
    const PROFIL_REFERENCE= "ref";
    public function load(ObjectManager $manager)
    {
        $Tab=['ADMIN','CM','FORMATEUR','APPRENANT'];
        foreach ($Tab as $key) { 
            $profil = new Profil();
            $profil ->setLibelle($key);
            $this->addReference($key, $profil);
            $manager->persist($profil);
            $manager->flush();

        }

    }
}
