<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimeZoneController extends AbstractController
{
    /**
     * @Route("/time/zone", name="app_time_zone")
     */
    public function index(): Response
    {
        return $this->render('time_zone/index.html.twig', [
            'controller_name' => 'TimeZoneController',
        ]);
    }
}
