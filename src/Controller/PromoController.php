<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Entity\Apprenant;
use App\Repository\PromoRepository;
use App\Repository\ReferentielRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromoController extends AbstractController

{
    public function __construct (SendMailService $email){

    }

    /**
     * @Route(
     *  name="createPromo",
     *   path="api/admin/promo",
     *   methods={"POST"}
     *)
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $manager
     * @param PromoRepository $promo
     * @param ReferentielRepository $ref
     * @param \Swift_Mailer $mailer
     * @return JsonResponse
     */
   
     public function ajoutPromo(Request $request, ValidatorInterface $validator,EntityManagerInterface $manager, PromoRepository $promo,ReferentielRepository $ref, Swift_Mailer $mailer){

        $promo=$request->request->all();
        $pro=new Promo();
        $pro->setLangue($promo['langue']);
        $pro->setDescription($promo['description']);
        $pro->setTitre($promo['titre']);
        $pro->setReferenceAgate($promo['referenceAgate']);
        $pro->setLieu($promo['lieu']);
        $pro->setEtat($promo['etat']);
        $pro->setFabrique($promo['fabrique']);
        $pro->setDateDebut(new \DateTime());
        $pro->setDateFinProvisoire(new \DateTime());
        $pro->setDateFinReelle(new \DateTime());

        $referentiel= $ref->findOneBy(["id"=>$promo['referentiels']]);
        if ($referentiel) {
            $pro->addRefereftiel($referentiel);
        
        } 
   
      /*  if (isset($promo['apprenants'])) {
            foreach ($promo['apprenants'] as $value) {
                $app=new Apprenant();
                $app->setEmail($value);
                $email->mail($value, $mailer);
            }
        }*/
        $manager->persist($pro);
        $manager->flush();
        return $this->json('ok', 201);
     }
     
}
