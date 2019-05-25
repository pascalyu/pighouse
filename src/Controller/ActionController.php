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
    public function substract(HouseService $houseService, Request $request) {

        $pig = $this->get('security.token_storage')->getToken()->getUser();

        $houseService->init($pig);
        $amount = $request->get("amount");
        $houseService->substractAmount($amount);
        $action = $houseService->getActionEntity();
        $jsonContent = $houseService->getActionJsonFormat($action);

        $response = new JsonResponse();
        $response->setData(array('amount_saved' => true, 'action_entity' => $jsonContent));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/add", name="add", methods="GET")
     */
    public function add(HouseService $houseService, Request $request) {


        $pig = $this->get('security.token_storage')->getToken()->getUser();
        $houseService->init($pig);
        $amount = $request->get("amount");
        $houseService->addAmount($amount);
        $action = $houseService->getActionEntity();

        $jsonContent = $houseService->getActionJsonFormat($action);

        $response = new JsonResponse();
        $response->setData(array('amount_saved' => true, 'action_entity' => $jsonContent));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/", name="action_index", methods="GET")
     */
    public function index(ActionRepository $actionRepository): Response {


        //$houseRepo = $this->getDoctrine()->getRepository(House::class);
        $pig = $this->get('security.token_storage')->getToken()->getUser();
        $joinedHouse = $pig->getJoinedHouse();
        //$house = $houseRepo->find($joinedHouse->getId());
        $filters = array(
            'house' => $joinedHouse->getId(),
        );

        $actions = $actionRepository->findBy($filters, array('created_at' => 'DESC'));

        return $this->render('action/action.html.twig', [
                    'actions' => $actions,
                    'house_id' => $joinedHouse->getId(),
                    'house' => $joinedHouse,
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
    public function delete(HouseService $houseService, Action $action): Response {


        $pig = $this->get('security.token_storage')->getToken()->getUser();

        $houseService->init($pig);
        $houseService->deleteAction($action);
        $response = new JsonResponse();
        $jsonContent = $houseService->getActionJsonFormat($action);

        $response->setData(array('amount_deleted' => true, 'action_entity' => $jsonContent));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
