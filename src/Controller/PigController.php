<?php

namespace App\Controller;

use App\Entity\Pig;
use App\Form\Pig1Type;
use App\Repository\PigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/pig")
 */
class PigController extends AbstractController {

    /**
     * @Route("/", name="pig_index", methods="GET")
     */
    public function index(PigRepository $pigRepository): Response {
        return $this->render('pig/index.html.twig', ['pigs' => $pigRepository->findAll()]);
    }

    /**
     * @Route("/new", name="pig_new", methods="GET|POST")
     */
    public function new(Request $request): Response {
        $pig = new Pig();
        $form = $this->createForm(Pig1Type::class, $pig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pig);
            $em->flush();

            return $this->redirectToRoute('pig_index');
        }

        return $this->render('pig/new.html.twig', [
                    'pig' => $pig,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pig_show", methods="GET")
     */
    public function show(Pig $pig): Response {
        return $this->render('pig/show.html.twig', ['pig' => $pig]);
    }

    /**
     * @Route("/{id}/edit", name="pig_edit", methods="GET|POST")
     */
    public function edit(Request $request, Pig $pig): Response {
      
        $form = $this->createForm(Pig1Type::class, $pig);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pig_edit', ['id' => $pig->getId()]);
        }
        $pig->setHouses(NULL);
        $pig->setActions(NULL);
        return $this->render('pig/edit.html.twig', [
                    'pig' => $pig,
                    'form' => $form->createView(),
        ]);
        
        
     
        
        
    }

    /**
     * @Route("/{id}", name="pig_delete", methods="DELETE")
     */
    public function delete(Request $request, Pig $pig): Response {
        if ($this->isCsrfTokenValid('delete' . $pig->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pig);
            $em->flush();
        }

        return $this->redirectToRoute('pig_index');
    }

}
