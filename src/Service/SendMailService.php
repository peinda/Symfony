<?php
namespace App\Service;

class SendMailService{

public function mail($name, \Swift_Mailer $mailer){
    
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('mamependa2011@gmail.com')
        ->setTo($name)
        ->setBody(
            'Bonsoir Cher(e) candidat(e) à la sonatel Academy. \n Après les différentes étapes de sélection que tu as passé avec brio, nous t’informons que ta candidature a été retenue pour intégrer la promotion cette année de la première école de codage gratuite du Sénégal.\n Rendez-vous sur www.sonatelacademy.sn et voici vos informations de connexion :\n Username: ".$user->getEmail()." \n Password : ".$password." '
        )
    ;
    $mailer->send($message);

}
}
