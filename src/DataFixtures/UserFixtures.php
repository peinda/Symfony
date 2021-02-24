<?php

namespace App\DataFixtures;

use App\Entity\Cm;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Profil;
use App\Entity\Apparent;
use App\Entity\Formateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __Construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;

    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 12; $i++) {
            
            if($i<5){
                $user = new User();
                $user->setProfil($this->getReference("ADMIN"));
            }
            elseif ($i>=5 && $i<10) {
                $user = new Cm();
                $user->setProfil($this->getReference("CM"));
            }
            elseif ($i>=10 && $i<15) {
                $user = new Formateur();
                $user->setProfil($this->getReference("FORMATEUR"));
            }
            elseif($i>=15 && $i<20) {
                $user = new Apparent();
                $user->setProfil($this->getReference("APPRENANT"));
            }
               
            $user->setNom($faker->lastName);
            $user->setEmail($faker->email);
            $user->setPrenom($faker->firstName);
            $user->setArchived(1);
            $user->setAdresse($faker->city);
            $user->setTelephone($faker->phoneNumber);
            $user->setAvatar($faker->imageUrl());
            $user->setPassword($this->encoder->encodePassword($user,"passer"));

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
