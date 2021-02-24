<?php
namespace App\Service;

use App\Entity\Referentiel;
use App\Repository\ReferentielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReferentielService
{
    public function createReferentiel($request, $serialize, $manager){
        $referentiels = $request->request->all();
        $programme = $request->files->get("programme");
        //dd($programme);
        $programme = fopen($programme->getRealPath(),"rb");
        $referentiels["programme"]=$programme;
        //dd($referentiels);
        //$referentiels= $serialize->decode($referentiels, "json");
        $referentiels= $serialize->denormalize($referentiels,"App\\Entity\\Referentiel");
        //dd($referentiels);


        $manager->persist( $referentiels);
        $manager->flush();
        return new JsonResponse( $referentiels, Response::HTTP_CREATED);
    }
    }