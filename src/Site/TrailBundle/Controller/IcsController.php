<?php

namespace Site\TrailBundle\Controller;

use Site\TrailBundle\Entity\Ics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class IcsController extends Controller
{
    public function indexAction()
    {
        /*$array = array(
                Array(
                    "id" => "01",    
                    "debut" => "2015-02-13 10:30:00",
                    "fin" => "2015-02-13 12:30:00",
                    "lieu" => "MonLieu1",
                    "titre" => "Titre1",
                    "description" => "MaDesc1"
                ),
                Array(
                    "id" => "02",    
                    "debut" => "2015-02-13 13:30:00",
                    "fin" => "2015-02-13 15:30:00",
                    "lieu" => "MonLieu2",
                    "titre" => "Titre2",
                    "description" => "MaDesc2"
                )
            );*/
        
        if($this->getUser())
        {
            $idUser = $this->getUser()->getId();
        }
        else
        {
            $idUser = 0;
        }
        
        $dateDebut = new \DateTime('now');
        date_time_set($dateDebut, 0, 0);
        $dateFin = new \DateTime('now');
        date_time_set($dateFin, 0, 0);
        date_add($dateFin, date_interval_create_from_date_string('15 days'));
        
        $mesEvenements = CalendrierController::getAllEventFrom($idUser, $this->getDoctrine()->getManager(), $dateDebut, $dateFin);

        $ics = new Ics($mesEvenements);
        
        //date_default_timezone_set("UTC");

        //return new Response(var_dump(date("Y-m-d H:i:s", strtotime("2015-02-20 09:30"))));
        //return new Response(var_dump(date("Y-m-d H:i:s", mktime(9, 30, 0, 2, 20, 2015))));
        
        //echo var_dump(date("Ymd\THis\Z",strtotime("2015-02-20 09:30")));
        //return new Response(var_dump(date("Ymd\THis\Z", mktime(9, 30, 0, 2, 20, 2015))));
       
        
        //echo "DTSTART:20150213T083000Z" . "<br/>";
        //echo "DTSTART:".date("Ymd\THis\Z", strtotime("2015-02-13 08:30:00"." UTC")) . "<br/>";
       
        
        
        return new Response($ics->show());
        
        //return new Response(var_dump(date("Ymd\THis\ZT",strtotime("2015-02-20 09:30:00 UTC"))));
    }
}
