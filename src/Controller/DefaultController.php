<?php

namespace App\Controller;

use App\Entity\House;
use App\Entity\Invitation;
use App\Entity\Pig;
use App\Form\HouseType;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController {

    /**
     * @Route("/", name="index")
     */
    public function index() {


        $securityContext = $this->container->get('security.authorization_checker');
        /* if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          $pig = $this->get('security.token_storage')->getToken()->getUser();
          if (!$pig->hasHouse()) {
          return $this->redirectToRoute('createHouseForm', array("pigId" => $pig->getId()));
          }
          return $this->redirectToRoute('home');
          }
          if ($securityContext->isGranted('IS_AUTHENTICATED_ANONYMOUSLY ')) {

          return $this->redirectToRoute('security_login');
          }
          if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY ')) {

          return $this->redirectToRoute('home');
          } */

        return $this->redirectToRoute('security_login');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {

        return $this->render('default/home.html.twig');
    }

    /**
     * @Route("/success", name="successPage")
     */
    public function successPage($message = null) {
        return $this->render('default/success.html.twig', [
                    'message' => $message,
        ]);
    }

    /**
     * @Route("/createHouseForm/{pigId}", name="createHouseForm")
     */
    /* public function createHouseForm(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, $pigId) {
      $house = new House();
      $houseForm = $this->createForm(HouseType::class, $house);
      $houseForm->handleRequest($request);
      if ($houseForm->isSubmitted() && $houseForm->isValid()) {

      $pigRepo = $this->getDoctrine()->getRepository(Pig::class);
      $pig = $pigRepo->find($pigId);
      $house->setPig($pig);
      $house->setAmount(0);
      $house->addPig($pig);
      $pig->addHouse($house);

      $manager->persist($pig);

      $manager->persist($house);
      $manager->flush();
      return $this->redirectToRoute('successPage');
      }
      return $this->render('default/createHouseForm.html.twig', [
      'houseForm' => $houseForm->createView(),
      ]);
      }

      /**
     * @Route("/house/{id}", name="house")
     */
    public function editHouseForm($message = null) {
        $house = new House();
        $houseForm = $this->createForm(HouseType::class, $house);
        $houseForm->handleRequest($request);
        if ($houseForm->isSubmitted() && $houseForm->isValid()) {

            $manager->persist($house);
            $manager->flush();
            return $this->redirectToRoute('pig_house');
        }
        return $this->render('security/subscribe.html.twig', [
                    'pigForm' => $pigForm->createView(),
        ]);


        return $this->render('default/success.html.twig', [
                    'message' => $message,
        ]);
    }

    /**
     * @Route("/joinOrCreate", name="joinOrCreate")
     */
    public function joinOrCreate($message = null) {
        return $this->render('default/joinOrCreate.html.twig', [
                    'message' => $message,
        ]);
    }

    /**
     * @Route("/joinHouseForm", name="joinHouseForm")
     */
    public function joinHouseForm($message = null) {

        return $this->render('default/joinHouseForm.html.twig', [
                    'message' => $message,
        ]);
    }

    /**
     * @Route("/invitToHouseForm", name="invitToHouseForm")
     */
    /* public function invitToHouseForm(Request $request, ObjectManager $manager) {

      $houses=array();
      $pig = $this->get('security.token_storage')->getToken()->getUser();
      if($request->request->count()>0){
      $pigRepo = $this->getDoctrine()->getRepository(Pig::class);
      $pig_dest = $pigRepo->findOneBy(['email' => $request->request->get("email")]);

      $houseRepo = $this->getDoctrine()->getRepository(House::class);
      $house = $houseRepo->find( $request->request->get("houseId"));

      $invitation= new Invitation();
      $invitation->setPigSource($pig);
      $invitation->setPigDest($pig_dest);
      $invitation->setPigDest($pig_dest);
      $invitation->setHouse($house);
      $invitation->setState(Invitation::STATE_WAITING);
      $invitation->setCreatedAt(new DateTime());

      $manager->persist($invitation);
      $manager->flush();
      return $this->redirectToRoute('successPage');

      }


      if($pig->hasHouse()){
      $houses=$pig->getHouses();
      }
      return $this->render('default/invitToHouseForm.html.twig', [
      'houses' => $houses,
      'message' => $request->request->count()
      ]);
      } */
}
