<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeizigController extends AbstractController
{
    /**
     * @Route("/", name="geizig.home")
     */
    public function index(): Response
    {
        return $this->render('geizig/index.html.twig', [
            'page' => 'Home',
        ]);
    }
}