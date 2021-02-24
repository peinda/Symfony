<?php

namespace App\Controller;

use App\Repository\CompetencesRepository;
use App\Repository\ProfilRepository;
use App\Repository\ReferentielRepository;
use App\Repository\UserRepository;
use App\Service\ReferentielService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Compound;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReferentielController extends AbstractController
{
    /**
     * @Route(
     *   path="api/admin/referentiels",
     *   methods={"POST"}
     *)
     * @param ReferentielService $Refser
     * @param Request $request
     * @param SerializerInterface $serialize
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @param ReferentielRepository $ref
     * @return JsonResponse
     */
    public function callcreateReferentiel( ReferentielService $Refser, Request $request, SerializerInterface $serialize,EntityManagerInterface $manager,ValidatorInterface $validator,
                              UserPasswordEncoderInterface $encoder, ReferentielRepository $ref)
    {
        //dd($request->request->all());
        return $this->json($Refser->createReferentiel($request, $serialize, $manager),200);
    }

    /**
     * @Route(
     *   name="getItempref",
     *   path="/api/admin/referentiels/{idref}/grpecompetences/{idgrp}",
     *   methods={"GET"}
     *)
     * @param CompetencesRepository $competencesRepository
     * @param int $idref
     * @param int $idgrp
     * @return JsonResponse
     */
       public function  getcompGrpRef(CompetencesRepository $competencesRepository, int $idref, int $idgrp){

           $comp= $competencesRepository->getcompRef($idgrp,$idref);
           return $this->json($comp,Response::HTTP_OK);

       }

}


