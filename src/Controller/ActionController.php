<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\House;
use App\Form\ActionType;
use App\Repository\ActionRepository;
use App\Service\HouseService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/action")
 */
class ActionController extends AbstractController {
       /**
     * @Route("/substract", name="substract", methods="GET")
     */
    public function substract(HouseService $houseService, ObjectManager $manager, Request $request) {

        $houseId = $request->get("house_id");
      
        $pig = $this->get('security.token_storage')->getToken()->getUser();
  
        
       
        $houseService->init($pig,$houseId);
        $amount = $request->get("amount");
        $houseService->substractAmount($amount);
        $action =$houseService->getActionEntity();
        $jsonContent = $houseService->getActionJsonFormat($action);

        $response = new JsonResponse();
        $response->setData(array('amount_saved' => true, 'action_entity' => $jsonContent));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/add", name="add", methods="GET")
     */
    public function add(HouseService $houseService, ObjectManager $manager, Request $request) {

        $houseId = $request->get("house_id");
      
       
        $pig = $this->get('security.token_storage')->getToken()->getUser();
  
        
       
        $houseService->init($pig,$houseId);
        $amount = $request->get("amount");
        $houseService->addAmount($amount);
        $action =$houseService->getActionEntity();
        $jsonContent = $houseService->getActionJsonFormat($action);

        $response = new JsonResponse();
        $response->setData(array('amount_saved' => true, 'action_entity' => $jsonContent));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
   


 
    /**
     * @Route("/{houseId}", name="action_index", methods="GET")
     */
    public function index(HouseService $houseService, ActionRepository $actionRepository, $houseId): Response {
    

        $houseRepo = $this->getDoctrine()->getRepository(House::class);
        $house = $houseRepo->find($houseId);
        $filters = array(
            'house' => $houseId,
        );
        
        $actions=$houseService->addGreenRedClass($actionRepository->findBy($filters, array('created_at' => 'DESC')));
        return $this->render('action/action.html.twig', [
                    'actions' => $actions,
                    'house_id' => $houseId,
                    'house' => $house,
        ]);
    }
    
    /**
     * @Route("/new", name="action_new", methods="GET|POST")
     */
    public function new(Request $request): Response {
        $action = new Action();
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();

            return $this->redirectToRoute('action_index');
        }

        return $this->render('action/new.html.twig', [
                    'action' => $action,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_show", methods="GET")
     */
    public function show(Action $action): Response {
        return $this->render('action/show.html.twig', ['action' => $action]);
    }

    /**
     * @Route("/{id}/edit", name="action_edit", methods="GET|POST")
     */
    public function edit(Request $request, Action $action): Response {
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('action_edit', ['id' => $action->getId()]);
        }

        return $this->render('action/edit.html.twig', [
                    'action' => $action,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_delete", methods="DELETE")
     */
    public function delete(Request $request, Action $action): Response {
        if ($this->isCsrfTokenValid('delete' . $action->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($action);
            $em->flush();
        }

        return $this->redirectToRoute('action_index');
    }

}
