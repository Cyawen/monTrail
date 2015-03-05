<?php

namespace Site\TrailBundle\Controller;

use Site\TrailBundle\Entity\Ics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class IcsController extends Controller
{
    public function indexAction($id)
    {        
        //Cas où on clique sur le lien télécharger le calendrier dans le site
        if($id == "default")
        {
            if($this->getUser())
            {
                $idUser = $this->getUser()->getId();
            }
            else
            {
                $idUser = 0;
            }
        }
        else //Cas où on veut récupérer le calendrier "à l'exterieur" du site
        {
            $idUser = $id;
        }        
        
        $dateDebut = new \DateTime('now');
        date_time_set($dateDebut, 0, 0);
        $dateFin = new \DateTime('now');
        date_time_set($dateFin, 0, 0);
        date_add($dateFin, date_interval_create_from_date_string('15 days'));
        
        $mesEvenements = CalendrierController::getAllEventFrom($idUser, $this->getDoctrine()->getManager(), $dateDebut, $dateFin);

        $ics = new Ics($mesEvenements);        
        
        return new Response($ics->show());
        //return new Response("e");
    }
}
