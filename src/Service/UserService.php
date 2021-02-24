<?php
namespace App\Service;

use App\Entity\Cm;
use App\Entity\Formateur;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
        public function createUser($request, $serialize, $manager,$validator, $encoder,$rep,$prof){
            $User_json = $request->request->all();
            dd($User_json);
            $image = $request->files->get("avatar");
            $users=$prof->find($User_json['role']);
            $role= ucfirst((strtolower($users->getLibelle())));
            if ($role=="Admin") {
              $role= "User";
            }
            
            $User = $serialize->denormalize($User_json,"App\\Entity\\".$role);

            //dd($User_json);
            $image = fopen($image->getRealPath(),"rb");
            $User-> setAvatar($image);
            $User->setArchived(0);
            $password = $User->getPassword();
            $User-> SetPassword($encoder->encodePassword($User, $password));

            $User->setProfil($users);
            $manager->persist($User);
            $manager->flush();

            //dd($users);
            fclose($image);
            return("sucess");
            

}
public function editUser($request, $serialize, $manager,$validator, $encoder,$rep,$prof,$id){
    $User_json = $request->request->all();
    $user=$rep->find($id);
    //dd($User_json);
   
        if(empty($user)){
            $message="cet utilisateur n'existe pas";
            return $message;
        }
        $user->setNom($User_json['nom']);
        $user->setPrenom($User_json['prenom']);
        $user->setAdresse($User_json['adresse']);
        $user->setTelephone($User_json['telephone']);
        $user->setEmail($User_json['email']);
        $image = $request->files->get("avatar");
        
        if (isset($User_json['role'])) {
            $profil=$prof->find($User_json['role']);
            $user->setProfil($profil);
        }
        if ($image!==null) {
        
            $image = fopen($image->getRealPath(),"rb");
            $User-> setAvatar($image);
         }
       
         
        //dd($user);
        $manager->persist($user);
        $manager->flush();

        if ($image!==null) {
            # code...
            fclose($image);
         }

        return("sucess");
        

    }

}