<?php

namespace App\Controller;

use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('home/login.html.twig', [
            'controller_name' => 'HomeController',
            'locale' => 'fr',
        ]);
    }
}
