<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use App\Service;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route(
     *  name="createUser",
     *   path="api/admin/users",
     *   methods={"POST"}
     *)
     * @param UserService $user
     * @param Request $request
     * @param SerializerInterface $serialize
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @param UserRepository $rep
     * @param ProfilRepository $prof
     * @return JsonResponse
     */
    public function callBack( UserService $user, Request $request, SerializerInterface $serialize,EntityManagerInterface $manager,ValidatorInterface $validator,
                              UserPasswordEncoderInterface $encoder, UserRepository $rep,ProfilRepository $prof)
    {
        $entity="App\Entity\User";
        return $this->json($user->createUser($request, $serialize, $manager,$validator, $encoder,$rep,$prof),200);
    }

    /**
     * @Route(
     *  name="editUser",
     *   path="api/admin/users/{id}",
     *   methods={"POST"}
     *)
     * @param UserService $user
     * @param Request $request
     * @param SerializerInterface $serialize
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param UserRepository $rep
     * @param ProfilRepository $prof
     * @return JsonResponse
     */
    public function ModififUser( UserService $user, Request $request, SerializerInterface $serialize,EntityManagerInterface $manager,ValidatorInterface $validator,
                              UserPasswordEncoderInterface $encoder, UserRepository $rep,ProfilRepository $prof,$id)
    {
        return $this->json($user->editUser($request, $serialize, $manager,$validator, $encoder,$rep,$prof,$id),200);
    }
    
    }
