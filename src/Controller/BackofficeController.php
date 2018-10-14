<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pig;

class BackofficeController extends AbstractController
{
    /**
     * @Route("/backoffice", name="backoffice")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Pig::class);
        $pigs = $repo->findAll();
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
            'pigs' => $pigs,
        ]);
    }
     
}
