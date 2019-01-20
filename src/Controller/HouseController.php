<?php

namespace App\Controller;

use App\Entity\House;
use App\Form\House1Type;
use App\Repository\HouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/house")
 */
class HouseController extends AbstractController {

    /**
     * @Route("/", name="house_index", methods="GET")
     */
    public function index(HouseRepository $houseRepository): Response {
        $securityContext = $this->container->get('security.authorization_checker');

        $pig = $this->get('security.token_storage')->getToken()->getUser();
        
        $filters=array('pig'=>$pig->getId());
        return $this->render('house/index.html.twig', ['houses' => $houseRepository->findBy($filters)]);
    }

    /**
     * @Route("/new", name="house_new", methods="GET|POST")
     */
    public function new(Request $request): Response {
        $house = new House();
        $form = $this->createForm(House1Type::class, $house);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($house);
            $em->flush();

            return $this->redirectToRoute('house_index');
        }

        return $this->render('house/new.html.twig', [
                    'house' => $house,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="house_show", methods="GET")
     */
    public function show(House $house): Response {
        return $this->render('house/show.html.twig', ['house' => $house]);
    }

    /**
     * @Route("/{id}/edit", name="house_edit", methods="GET|POST")
     */
    public function edit(Request $request, House $house): Response {
        $form = $this->createForm(House1Type::class, $house);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('house_edit', ['id' => $house->getId()]);
        }

        return $this->render('house/edit.html.twig', [
                    'house' => $house,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="house_delete", methods="DELETE")
     */
    public function delete(Request $request, House $house): Response {
        if ($this->isCsrfTokenValid('delete' . $house->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($house);
            $em->flush();
        }

        return $this->redirectToRoute('house_index');
    }

}
